<?php

/*
 * LMS version 1.11-git
 *
 *  (C) Copyright 2001-2013 LMS Developers
 *
 *  Please, see the doc/AUTHORS for more information about authors!
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 *  $Id$
 */

// Invoiceless liabilities: Zobowiazania/obciazenia na ktore nie zostala wystawiona faktura
function GetCustomerCovenants($customerid)
{
	global $DB;

	if(!$customerid) return NULL;
	
	return $DB->GetAll('SELECT c.time, c.value*-1 AS value, c.comment, c.taxid, 
			taxes.label AS tax, c.id AS cashid,
			ROUND(c.value / (taxes.value/100+1), 2)*-1 AS net
			FROM cash c
			LEFT JOIN taxes ON (c.taxid = taxes.id)
			WHERE c.customerid = ? AND c.docid = 0 AND c.value < 0
			ORDER BY time', array($customerid));
}

$layout['pagetitle'] = trans('New Invoice');

$taxeslist = $LMS->GetTaxes();

$SESSION->restore('invoicecontents', $contents);
$SESSION->restore('invoicecustomer', $customer);
$SESSION->restore('invoice', $invoice);
$SESSION->restore('invoicenewerror', $error);

$itemdata = r_trim($_POST);

$action = isset($_GET['action']) ? $_GET['action'] : NULL;

// ADESCOM
if (isset($itemdata['extraposition_details'])) {
        $extraposition = $itemdata['extraposition_details'];
} else {
        $SESSION->restore('invoiceextraposition', $extraposition);
}

if (isset($_POST['adescom_action'])) {
        $action = $_POST['adescom_action'];
}
// ADESCOM


switch($action)
{
	case 'init':

		unset($invoice);
		unset($contents);
		unset($customer);
		unset($error);

		// get default invoice's numberplanid and next number
		$currtime = time();
		$invoice['cdate'] = $currtime;
		$invoice['sdate'] = $currtime;
		$invoice['paytime'] = ConfigHelper::getConfig('invoices.paytime');
//		$invoice['paytype'] = ConfigHelper::getConfig('invoices.paytype');

		if(!empty($_GET['customerid']) && $LMS->CustomerExists($_GET['customerid']))
		{
			$customer = $LMS->GetCustomer($_GET['customerid'], true);

			$invoice['numberplanid'] = $DB->GetOne('SELECT n.id FROM numberplans n
				JOIN numberplanassignments a ON (n.id = a.planid)
				WHERE n.doctype = ? AND n.isdefault = 1 AND a.divisionid = ?',
				array(DOC_INVOICE, $customer['divisionid']));
		}

		if(empty($invoice['numberplanid']))
			$invoice['numberplanid'] = $DB->GetOne('SELECT id FROM numberplans
				WHERE doctype = ? AND isdefault = 1', array(DOC_INVOICE));
		
		// ADESCOM
                $date = strtotime("-1 month", $invoice['cdate']);
		
                $extraposition['fromdate'] = DateTimeHelper::parseDateArray(DateTimeHelper::dateTrunc($date, 'month', false));
                $extraposition['todate'] = DateTimeHelper::parseDateArray(DateTimeHelper::dateTrunc($date, 'month', true));
		// ADESCOM
		
	break;

	case 'additem':

		unset($error);

		$itemdata['discount'] = str_replace(',', '.', $itemdata['discount']);
		$itemdata['pdiscount'] = 0;
		$itemdata['vdiscount'] = 0;
		if (preg_match('/^[0-9]+(\.[0-9]+)*$/', $itemdata['discount'])) {
			$itemdata['pdiscount'] = ($itemdata['discount_type'] == DISCOUNT_PERCENTAGE ? floatval($itemdata['discount']) : 0);
			$itemdata['vdiscount'] = ($itemdata['discount_type'] == DISCOUNT_AMOUNT ? floatval($itemdata['discount']) : 0);
		}
		if ($itemdata['pdiscount'] < 0 || $itemdata['pdiscount'] > 99.9 || $itemdata['vdiscount'] < 0)
			$error['discount'] = trans('Wrong discount value!');

		if ($error)
			break;

		foreach(array('count', 'pdiscount', 'vdiscount', 'valuenetto', 'valuebrutto') as $key)
			$itemdata[$key] = f_round($itemdata[$key]);

		if($itemdata['count'] > 0 && $itemdata['name'] != '')
		{
			$taxvalue = isset($itemdata['taxid']) ? $taxeslist[$itemdata['taxid']]['value'] : 0;
			if($itemdata['valuenetto'] != 0)
			{
				$itemdata['valuenetto'] = f_round(($itemdata['valuenetto'] - $itemdata['valuenetto'] * $itemdata['pdiscount'] / 100) - $itemdata['vdiscount']);
				$itemdata['valuebrutto'] = round($itemdata['valuenetto'] * ($taxvalue / 100 + 1),2);
			}
			elseif($itemdata['valuebrutto'] != 0)
			{
				$itemdata['valuebrutto'] = f_round(($itemdata['valuebrutto'] - $itemdata['valuebrutto'] * $itemdata['pdiscount'] / 100) - $itemdata['vdiscount']);
				$itemdata['valuenetto'] = round($itemdata['valuebrutto'] / ($taxvalue / 100 + 1), 2);
			}

			// str_replace->f_round here is needed because of bug in some PHP versions
			$itemdata['s_valuebrutto'] = f_round($itemdata['valuebrutto'] * $itemdata['count']);
			$itemdata['s_valuenetto'] = f_round($itemdata['s_valuebrutto'] /  ($taxvalue / 100 + 1));
			$itemdata['valuenetto'] = f_round($itemdata['valuenetto']);
			$itemdata['valuebrutto'] = f_round($itemdata['valuebrutto']);
			$itemdata['count'] = f_round($itemdata['count']);
			$itemdata['discount'] = f_round($itemdata['discount']);
			$itemdata['pdiscount'] = f_round($itemdata['pdiscount']);
			$itemdata['vdiscount'] = f_round($itemdata['vdiscount']);
			$itemdata['tax'] = isset($itemdata['taxid']) ? $taxeslist[$itemdata['taxid']]['label'] : '';
			$itemdata['posuid'] = (string) getmicrotime();
			$contents[] = $itemdata;
		}
	break;

	case 'additemlist':

		if($marks = $_POST['marks'])
		{
			foreach($marks as $id)
			{
				$cash = $DB->GetRow('SELECT value, comment, taxid 
						    FROM cash WHERE id = ?', array($id));

				$itemdata['cashid'] = $id;
				$itemdata['name'] = $cash['comment'];
				$itemdata['taxid'] = $cash['taxid'];
				$itemdata['tax'] = isset($taxeslist[$itemdata['taxid']]) ? $taxeslist[$itemdata['taxid']]['label'] : '';
				$itemdata['discount'] = 0;
				$itemdata['pdiscount'] = 0;
				$itemdata['vdiscount'] = 0;
				$itemdata['count'] = f_round($_POST['l_count'][$id]);
				$itemdata['valuebrutto'] = f_round((-$cash['value'])/$itemdata['count']);
				$itemdata['s_valuebrutto'] = f_round(-$cash['value']);
				$itemdata['valuenetto'] = round($itemdata['valuebrutto'] / ((isset($taxeslist[$itemdata['taxid']]) ? $taxeslist[$itemdata['taxid']]['value'] : 0) / 100 + 1), 2);
				$itemdata['s_valuenetto'] = round($itemdata['s_valuebrutto'] / ((isset($taxeslist[$itemdata['taxid']]) ? $taxeslist[$itemdata['taxid']]['value'] : 0) / 100 + 1), 2);
				$itemdata['prodid'] = $_POST['l_prodid'][$id];
				$itemdata['jm'] = $_POST['l_jm'][$id];
				$itemdata['posuid'] = (string) (getmicrotime()+$id);
				$itemdata['tariffid'] = 0;
				$contents[] = $itemdata;
			}
		}
	break;
 	case 'addextraitems':
 		$items = isset($_POST['extraposition']) ? $_POST['extraposition'] : NULL;
 	
 		if ($items && is_array($items))
 		{
 			foreach ($items as $itemdata)
 			{
 				foreach(array('count', 'discount', 'valuenetto', 'valuebrutto') as $key)
 					$itemdata[$key] = f_round($itemdata[$key]);
 
 				if($itemdata['count'] > 0 && $itemdata['name'] != '')
 				{
 					$taxvalue = isset($itemdata['taxid']) ? $taxeslist[$itemdata['taxid']]['value'] : 0;
 					if($itemdata['valuenetto'] != 0)
 					{
 						$itemdata['valuenetto'] = f_round($itemdata['valuenetto'] - $itemdata['valuenetto'] * f_round($itemdata['discount'])/100);
 						$itemdata['valuebrutto'] = round($itemdata['valuenetto'] * ($taxvalue / 100 + 1),2);
 					}
 					elseif($itemdata['valuebrutto'] != 0)
 					{
 						$itemdata['valuebrutto'] = f_round($itemdata['valuebrutto'] - $itemdata['valuebrutto'] * f_round($itemdata['discount'])/100);
 						$itemdata['valuenetto'] = round($itemdata['valuebrutto'] / ($taxvalue / 100 + 1), 2);
 					}
                                         
 					// str_replace here is needed because of bug in some PHP versions (4.3.10)
 					$itemdata['s_valuebrutto'] = f_round($itemdata['valuebrutto'] * $itemdata['count']);
 					$itemdata['s_valuenetto'] = f_round($itemdata['s_valuebrutto'] / ($taxvalue / 100 + 1));
 					$itemdata['valuenetto'] = f_round($itemdata['valuenetto']);
 					$itemdata['valuebrutto'] = f_round($itemdata['valuebrutto']);
 					$itemdata['count'] = f_round($itemdata['count']);
 					$itemdata['discount'] = f_round($itemdata['discount']);
                                         $itemdata['pdiscount'] = f_round($itemdata['pdiscount']);
                                         $itemdata['vdiscount'] = f_round($itemdata['vdiscount']);
 					$itemdata['tax'] = isset($itemdata['taxid']) ? $taxeslist[$itemdata['taxid']]['label'] : '';
 					$itemdata['posuid'] = (string) getmicrotime();
 					$itemdata['tariffid'] = 0;
 					$contents[] = $itemdata;
 				}
 			}
 		}	

 	break;

	case 'deletepos':
		if(sizeof($contents))
			foreach($contents as $idx => $row)
				if($row['posuid'] == $_GET['posuid']) 
					unset($contents[$idx]);
	break;

	case 'setcustomer':

		unset($invoice); 
		unset($customer);
		unset($error);

		if($invoice = $_POST['invoice'])
			foreach($invoice as $key => $val)
				$invoice[$key] = $val;

		$invoice['customerid'] = $_POST['customerid'];

		$currtime = time();

		if($invoice['sdate'])
		{
			list($syear, $smonth, $sday) = explode('/', $invoice['sdate']);
			if(checkdate($smonth, $sday, $syear)) 
			{
				$invoice['sdate'] = mktime(date('G', $currtime), date('i', $currtime), date('s', $currtime), $smonth, $sday, $syear);
				$scurrmonth = $smonth;
			}
			else
			{
				$error['sdate'] = trans('Incorrect date format!');
				$invoice['sdate'] = $currtime;
				break;
			}
		}
		else
			$invoice['sdate'] = $currtime;

		if($invoice['cdate'])
		{
			list($year, $month, $day) = explode('/', $invoice['cdate']);
			if(checkdate($month, $day, $year)) 
			{
				$invoice['cdate'] = mktime(date('G', $currtime), date('i', $currtime), date('s', $currtime), $month, $day, $year);
				$currmonth = $month;
			}
			else
			{
				$error['cdate'] = trans('Incorrect date format!');
				$invoice['cdate'] = $currtime;
				break;
			}
		}

		if($invoice['cdate'] && !isset($invoice['cdatewarning']))
		{
			$maxdate = $DB->GetOne('SELECT MAX(cdate) FROM documents WHERE type = ? AND numberplanid = ?', 
					array(DOC_INVOICE, $invoice['numberplanid']));

			if($invoice['cdate'] < $maxdate)
			{
				$error['cdate'] = trans('Last date of invoice settlement is $a. If sure, you want to write invoice with date of $b, then click "Submit" again.',
					date('Y/m/d H:i', $maxdate), date('Y/m/d H:i', $invoice['cdate']));
				$invoice['cdatewarning'] = 1;
			}
		}
		elseif(!$invoice['cdate'])
			$invoice['cdate'] = $currtime;

		if($invoice['number'])
		{
			if(!preg_match('/^[0-9]+$/', $invoice['number']))
				$error['number'] = trans('Invoice number must be integer!');
			elseif($LMS->DocumentExists($invoice['number'], DOC_INVOICE, $invoice['numberplanid'], $invoice['cdate']))
				$error['number'] = trans('Invoice number $a already exists!', $invoice['number']);
		}

		if(empty($invoice['paytime_default']) && !preg_match('/^[0-9]+$/', $invoice['paytime']))
		{
			$error['paytime'] = trans('Integer value required!');
		}

		if(!isset($error))
		{
    		$cid = isset($_GET['customerid']) && $_GET['customerid'] != '' ? intval($_GET['customerid']) : intval($_POST['customerid']);

			if($LMS->CustomerExists($cid))
				$customer = $LMS->GetCustomer($cid, true);

			// finally check if selected customer can use selected numberplan
			if($invoice['numberplanid'] && isset($customer))
				if(!$DB->GetOne('SELECT 1 FROM numberplanassignments
					WHERE planid = ? AND divisionid = ?', array($invoice['numberplanid'], $customer['divisionid'])))
				{
					$error['number'] = trans('Selected numbering plan doesn\'t match customer\'s division!');
					unset($customer);
				}
			// ADESCOM
                        $date = strtotime("-1 month", $invoice['cdate']);
			
                        $extraposition['fromdate'] = DateTimeHelper::parseDateArray(DateTimeHelper::dateTrunc($date, 'month', false));
                        $extraposition['todate'] = DateTimeHelper::parseDateArray(DateTimeHelper::dateTrunc($date, 'month', true));
			// ADESCOM	
		}
	break;

	case 'save':

		if (empty($contents) || empty($customer))
			break;

		unset($error);

		// set paytime
		if(!empty($invoice['paytime_default']))
		{
			if($customer['paytime'] != -1)
				$invoice['paytime'] = $customer['paytime'];
			elseif(($paytime = $DB->GetOne('SELECT inv_paytime FROM divisions 
				WHERE id = ?', array($customer['divisionid']))) !== NULL)
				$invoice['paytime'] = $paytime;
			else
				$invoice['paytime'] = ConfigHelper::getConfig('invoices.paytime');
		}
		// set paytype
		if(empty($invoice['paytype']))
		{
			if($customer['paytype'])
				$invoice['paytype'] = $customer['paytype'];
			elseif($paytype = $DB->GetOne('SELECT inv_paytype FROM divisions 
				WHERE id = ?', array($customer['divisionid'])))
				$invoice['paytype'] = $paytype;
			else if (($paytype = intval(ConfigHelper::getConfig('invoices.paytype'))) && isset($PAYTYPES[$paytype]))
				$invoice['paytype'] = $paytype;
		    else
		        $error['paytype'] = trans('Default payment type not defined!');
		}

		if ($error)
			break;

		$DB->BeginTrans();
		$DB->LockTables(array('documents', 'cash', 'invoicecontents', 'numberplans', 'divisions'));

		if(!$invoice['number'])
			$invoice['number'] = $LMS->GetNewDocumentNumber(DOC_INVOICE, $invoice['numberplanid'], $invoice['cdate']);
		else {
			if(!preg_match('/^[0-9]+$/', $invoice['number']))
				$error['number'] = trans('Invoice number must be integer!');
			elseif($LMS->DocumentExists($invoice['number'], DOC_INVOICE, $invoice['numberplanid'], $invoice['cdate']))
				$error['number'] = trans('Invoice number $a already exists!', $invoice['number']);

			if($error) {
				$invoice['number'] = $LMS->GetNewDocumentNumber(DOC_INVOICE, $invoice['numberplanid'], $invoice['cdate']);
				$error = null;
			}
		}

		$invoice['type'] = DOC_INVOICE;
		$iid = $LMS->AddInvoice(array('customer' => $customer, 'contents' => $contents, 'invoice' => $invoice));

		// usuwamy wczesniejsze zobowiazania bez faktury
		foreach ($contents as $item)
			if (!empty($item['cashid']))
				$ids[] = intval($item['cashid']);

		if (!empty($ids)) {
			if ($SYSLOG)
				foreach ($ids as $cashid) {
					$args = array(
						$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_CASH] => $cashid,
						$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_CUST] => $customer['id'],
					);
					$SYSLOG->AddMessage(SYSLOG_RES_CASH, SYSLOG_OPER_DELETE, $args,
						array_keys($args));
				}
			$DB->Execute('DELETE FROM cash WHERE id IN (' . implode(',', $ids) . ')');
		}

		$DB->UnLockTables();
		$DB->CommitTrans();

		$SESSION->remove('invoicecontents');
		$SESSION->remove('invoicecustomer');
		$SESSION->remove('invoice');
		$SESSION->remove('invoicenewerror');

		if(isset($_GET['print']))
			$SESSION->save('invoiceprint', array('invoice' => $iid,
				'original' => !empty($_GET['original']) ? 1 : 0,
				'copy' => !empty($_GET['copy']) ? 1 : 0));

		$SESSION->redirect('?m=invoicenew&action=init');
	break;
}

$SESSION->save('invoice', $invoice);
$SESSION->save('invoicecontents', isset($contents) ? $contents : NULL);
$SESSION->save('invoicecustomer', isset($customer) ? $customer : NULL);
$SESSION->save('invoicenewerror', isset($error) ? $error : NULL);

// ADESCOM
$SESSION->save('invoiceextraposition', $extraposition);
// ADESCOM

if($action)
{
	// redirect needed because we don't want to destroy contents of invoice in order of page refresh
	$SESSION->redirect('?m=invoicenew');
}

$covenantlist = array();
$list = GetCustomerCovenants($customer['id']);

if(isset($list))
	if($contents)
		foreach($list as $row)
		{
			$i = 0;
			foreach($contents as $item)
				if(isset($item['cashid']) && $row['cashid'] == $item['cashid'])
				{
					$i = 1;
					break;
				}
			if(!$i)
				$covenantlist[] = $row;
		}
	else
		$covenantlist = $list;

if (!ConfigHelper::checkValue(ConfigHelper::getConfig('phpui.big_networks', false)))
{
        $SMARTY->assign('customers', $LMS->GetCustomerNames());
}

if($newinvoice = $SESSION->get('invoiceprint'))
{
        $SMARTY->assign('newinvoice', $newinvoice);
        $SESSION->remove('invoiceprint');
}

// ADESCOM
$invoice_manager = new AdescomInvoiceManager();
$GLOBALS['EXTRAPOSITIONS'] = $extrapositions = $invoice_manager->getInvoiceExtraPositions();
	
function get_extra_position($type, $date_from, $date_to, $customer_id)
{
    $LMS = $GLOBALS['LMS'];
    $SMARTY = $GLOBALS['SMARTY'];
    $extrapositions = $GLOBALS['EXTRAPOSITIONS'];

    $taxeslist = $LMS->GetTaxes();

    $response = new xajaxResponse();

    $errors = array();

    // check required fields
    if (empty($type))
        $errors[] = trans('You must select position type!');

    if (empty($date_from))
        $errors[] = trans('You must enter "from" date!');

    if (empty($date_to))
        $errors[] = trans('You must enter "to" date!');

    if (empty($customer_id))
        $errors[] = trans('You must select customer first');

    // try get invoice position...
    if (empty($errors)) {
        try {
            $date_from = strtotime($date_from);
            $date_to = strtotime($date_to);

            $array_to = DateTimeHelper::dateParseStamp($date_to);
            $array_from = DateTimeHelper::dateParseStamp($date_from);

            $array_from['hour'] = 0;
            $array_from['minute'] = 0;
            $array_from['second'] = 0;

            $array_to['hour'] = 23;
            $array_to['minute'] = 59;
            $array_to['second'] = 59;

            $date_from = DateTimeHelper::parseDateArray($array_from);
            $date_to = DateTimeHelper::parseDateArray($array_to);

            // check for errors
            if ($date_from === false || $date_to === false) {
                if ($date_from === false)
                    $errors[] = trans('Invalid "from" date format');

                if ($date_to === false)
                    $errors[] = trans('Invalid "to" date format');
            }
            else {
                // parse type
                switch ($type) {
                    case 'voip_calls':
                        $invoice_manager = new AdescomInvoiceManager();
                        $positions = $invoice_manager->GetVoipCallsInvoicePosition($customer_id, $date_from, $date_to);
                        break;
                    default:
                        $errors[] = trans('Unsupported position type!');
                }
            }
        } catch (Exception $e) {
            error_log($e);

            $response->alert(trans('Unable to communicate with Adescom CTM system. Please contact Adescom support.'));

            return $response;
        }
    }

    // check for errors...
    if (empty($errors)) {
    // go through all positions
        foreach ($positions as $i => $position) {
            if ($position['subscribe']) {
                $name = ConfigHelper::GetConfig('adescom.invoice_position_subscribe');

                $name = str_replace('%subscribe_period', date("m/Y", $position['period']), $name);
            } else {
                $name = ConfigHelper::GetConfig('adescom.invoice_position_calls');

                $name = str_replace('%calls_fraction', $position['fraction'], $name);
                $name = str_replace('%calls_count', $position['count'], $name);
                $name = str_replace('%calls_periodfrom', date("Y/m/d", $date_from), $name);
                $name = str_replace('%calls_periodto', date("Y/m/d", $date_to), $name);
            }

            $positions[$i]['name'] = $name;
        }

        // pass position & config to template
        $SMARTY->assign('positions', $positions);
        $SMARTY->assign('taxeslist', $taxeslist);

        // render template
        $output = $SMARTY->fetch('invoicenew-adescom.html');

        // render position
        $response->assign('extra_positions', 'innerHTML', $output);
    } else
        $response->alert(implode("\n", $errors));

    // render response
    return $response;
}

$LMS->InitXajax();
$LMS->RegisterXajaxFunction('get_extra_position');

$SMARTY->assign('extraposition', $extraposition);

$SMARTY->assign('xajax', $LMS->RunXajax());
$SMARTY->assign('adescom', true);
$SMARTY->assign('extrapositions', $extrapositions);
// ADESCOM

$SMARTY->assign('covenantlist', $covenantlist);
$SMARTY->assign('error', $error);
$SMARTY->assign('contents', $contents);
$SMARTY->assign('customer', $customer);
$SMARTY->assign('invoice', $invoice);
$SMARTY->assign('tariffs', $LMS->GetTariffs());
$SMARTY->assign('numberplanlist', $LMS->GetNumberPlans(DOC_INVOICE, date('Y/m', $invoice['cdate'])));
$SMARTY->assign('taxeslist', $taxeslist);
$SMARTY->display('invoice/invoicenew.html');

?>
