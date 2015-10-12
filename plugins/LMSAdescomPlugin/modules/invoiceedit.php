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

$taxeslist = $LMS->GetTaxes();
$action = isset($_GET['action']) ? $_GET['action'] : '';

if(isset($_GET['id']) && $action == 'edit')
{
	$invoice = $LMS->GetInvoiceContent($_GET['id']);

	$SESSION->remove('invoicecontents');
	$SESSION->remove('invoicecustomer');

	$i = 0;
	foreach ($invoice['content'] as $item) {
		$i++;
		$nitem['tariffid']	= $item['tariffid'];
		$nitem['name']		= $item['description'];
		$nitem['prodid']	= $item['prodid'];
		$nitem['count']		= str_replace(',' ,'.', $item['count']);
		$nitem['discount']	= str_replace(',' ,'.', $item['pdiscount']);
		$nitem['pdiscount']	= str_replace(',' ,'.', $item['pdiscount']);
		$nitem['vdiscount']	= str_replace(',' ,'.', $item['vdiscount']);
		$nitem['jm']		= str_replace(',' ,'.', $item['content']);
		$nitem['valuenetto']	= str_replace(',' ,'.', $item['basevalue']);
		$nitem['valuebrutto']	= str_replace(',' ,'.', $item['value']);
		$nitem['s_valuenetto']	= str_replace(',' ,'.', $item['totalbase']);
		$nitem['s_valuebrutto']	= str_replace(',' ,'.', $item['total']);
		$nitem['tax']		= isset($taxeslist[$item['taxid']]) ? $taxeslist[$item['taxid']]['label'] : '';
		$nitem['taxid']		= $item['taxid'];
		$nitem['posuid']	= $i;
		$SESSION->restore('invoicecontents', $invoicecontents);
		$invoicecontents[] = $nitem;
		$SESSION->save('invoicecontents', $invoicecontents);
	}
	$SESSION->save('invoicecustomer', $LMS->GetCustomer($invoice['customerid'], true));
	$invoice['oldcdate'] = $invoice['cdate'];
	$invoice['oldsdate'] = $invoice['sdate'];
	$SESSION->save('invoice', $invoice);
	$SESSION->save('invoiceid', $invoice['id']);
}

$SESSION->restore('invoicecontents', $contents);
$SESSION->restore('invoicecustomer', $customer);
$SESSION->restore('invoice', $invoice);
$SESSION->restore('invoiceediterror', $error);
$itemdata = r_trim($_POST);

$ntempl = docnumber($invoice['number'], $invoice['template'], $invoice['cdate']);
$layout['pagetitle'] = trans('Invoice Edit: $a', $ntempl);

if(isset($_GET['customerid']) && $_GET['customerid'] != '' && $LMS->CustomerExists($_GET['customerid']))
	$action = 'setcustomer';

// ADESCOM
if (isset($itemdata['extraposition_details']))
    $extraposition = $itemdata['extraposition_details'];
else
    $SESSION->restore('invoiceextraposition', $extraposition);

if (isset($_POST['adescom_action']))
    $action = $_POST['adescom_action'];
// ADESCOM	

switch($action)
{
	case 'additem':
		if ($invoice['closed'])
			break;

		$itemdata = r_trim($_POST);

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

		foreach(array('count', 'discount', 'pdiscount', 'vdiscount', 'valuenetto', 'valuebrutto') as $key)
			$itemdata[$key] = round((float) str_replace(',', '.', $itemdata[$key]), 2);

		if ($itemdata['count'] > 0 && $itemdata['name'] != '')
		{
			$taxvalue = $taxeslist[$itemdata['taxid']]['value'];
			if ($itemdata['valuenetto'] != 0)
			{
				$itemdata['valuenetto'] = f_round(($itemdata['valuenetto'] - $itemdata['valuenetto'] * f_round($itemdata['pdiscount']) / 100) - $itemdata['vdiscount']);
				$itemdata['valuebrutto'] = round($itemdata['valuenetto'] * ($taxvalue / 100 + 1), 2);
			}
			elseif ($itemdata['valuebrutto'] != 0)
			{
				$itemdata['valuebrutto'] = f_round(($itemdata['valuebrutto'] - $itemdata['valuebrutto'] * $itemdata['pdiscount'] / 100) - $itemdata['vdiscount']);
				$itemdata['valuenetto'] = round($itemdata['valuebrutto'] / ($taxvalue / 100 + 1), 2);
			}

			// str_replace here is needed because of bug in some PHP versions (4.3.10)
			$itemdata['s_valuebrutto'] = str_replace(',', '.', $itemdata['valuebrutto'] * $itemdata['count']);
			$itemdata['s_valuenetto'] = str_replace(',', '.', $itemdata['s_valuebrutto'] / ($taxvalue / 100 + 1));
			$itemdata['valuenetto'] = str_replace(',', '.', $itemdata['valuenetto']);
			$itemdata['valuebrutto'] = str_replace(',', '.', $itemdata['valuebrutto']);
			$itemdata['count'] = str_replace(',', '.', $itemdata['count']);
			$itemdata['discount'] = str_replace(',', '.', $itemdata['discount']);
			$itemdata['pdiscount'] = str_replace(',', '.', $itemdata['pdiscount']);
			$itemdata['vdiscount'] = str_replace(',', '.', $itemdata['vdiscount']);
			$itemdata['tax'] = $taxeslist[$itemdata['taxid']]['label'];
			$itemdata['posuid'] = (string) getmicrotime();
			$contents[] = $itemdata;
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
 					$itemdata['s_valuebrutto'] = str_replace(',','.',$itemdata['valuebrutto'] * $itemdata['count']);
 					$itemdata['s_valuenetto'] = str_replace(',','.',$itemdata['s_valuebrutto'] / ($taxvalue / 100 + 1));
 					$itemdata['valuenetto'] = str_replace(',','.',$itemdata['valuenetto']);
 					$itemdata['valuebrutto'] = str_replace(',','.',$itemdata['valuebrutto']);
 					$itemdata['count'] = str_replace(',','.',$itemdata['count']);
 					$itemdata['discount'] = str_replace(',','.',$itemdata['discount']);
 					$itemdata['tax'] = $taxeslist[$itemdata['taxid']]['label'];
 					$itemdata['posuid'] = (string) getmicrotime();
 					$itemdata['tariffid'] = 0;
 					
 					$contents[] = $itemdata;
 				}
 			}
 		}	
 	break;	
	case 'deletepos':
		if ($invoice['closed'])
			break;

		if (sizeof($contents))
			foreach($contents as $idx => $row)
				if ($row['posuid'] == $_GET['posuid']) 
					unset($contents[$idx]);
	break;

	case 'setcustomer':

		$oldcdate = $invoice['oldcdate'];
		$oldsdate = $invoice['oldsdate'];
		$closed   = $invoice['closed'];

		unset($invoice);
		unset($customer);
		unset($error);
		$error = NULL;

		if($invoice = $_POST['invoice'])
			foreach($invoice as $key => $val)
				$invoice[$key] = $val;

		$invoice['paytime'] = sprintf('%d', $invoice['paytime']);
		$invoice['oldcdate'] = $oldcdate;
		$invoice['oldsdate'] = $oldsdate;

		if($invoice['paytime'] < 0)
			$invoice['paytime'] = 14;

		if($invoice['cdate']) // && !$invoice['cdatewarning'])
		{
			list($year, $month, $day) = explode('/', $invoice['cdate']);
			if(checkdate($month, $day, $year))
			{
				$oldday = date('d', $invoice['oldcdate']);
				$oldmonth = date('m', $invoice['oldcdate']);
				$oldyear = date('Y', $invoice['oldcdate']);

				if($oldday != $day || $oldmonth != $month || $oldyear != $year)
				{
					$invoice['cdate'] = mktime(date('G', time()), date('i', time()), date('s', time()), $month, $day, $year);
				}
				else // save hour/min/sec value if date is the same
					$invoice['cdate'] = $invoice['oldcdate'];
			}
			else
				$error['cdate'] = trans('Incorrect date format!');
		}

		if($invoice['sdate'])
		{
			list($syear, $smonth, $sday) = explode('/', $invoice['sdate']);
			if(checkdate($smonth, $sday, $syear))
			{
				$oldsday = date('d', $invoice['oldsdate']);
				$oldsmonth = date('m', $invoice['oldsdate']);
				$oldsyear = date('Y', $invoice['oldsdate']);

				if($oldsday != $sday || $oldsmonth != $smonth || $oldsyear != $syear)
				{
					$invoice['sdate'] = mktime(date('G', time()), date('i', time()), date('s', time()), $smonth, $sday, $syear);
				}
				else // save hour/min/sec value if date is the same
					$invoice['sdate'] = $invoice['oldsdate'];
			}
			else
				$error['sdate'] = trans('Incorrect date format!');
		}

		$invoice['customerid'] = $_POST['customerid'];
		$invoice['closed']     = $closed;

		if(!$error)
			if($LMS->CustomerExists($invoice['customerid']))
				$customer = $LMS->GetCustomer($invoice['customerid'], true);
	break;

	case 'save':
		if (empty($contents) || empty($customer))
			break;

		$SESSION->restore('invoiceid', $invoice['id']);
		$invoice['type'] = DOC_INVOICE;

		$currtime = time();
		$cdate = $invoice['cdate'] ? $invoice['cdate'] : $currtime;
		$sdate = $invoice['sdate'] ? $invoice['sdate'] : $currtime;
		$iid   = $invoice['id'];

		$DB->BeginTrans();

		$division = $DB->GetRow('SELECT name, shortname, address, city, zip, countryid, ten, regon,
			account, inv_header, inv_footer, inv_author, inv_cplace 
			FROM divisions WHERE id = ? ;',array($customer['divisionid']));

		$args = array(
			'cdate' => $cdate,
			'sdate' => $sdate,
			'paytime' => $invoice['paytime'],
			'paytype' => $invoice['paytype'],
			$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_CUST] => $customer['id'],
			'name' => $customer['customername'],
			'address' => $customer['address'],
			'ten' => $customer['ten'],
			'ssn' => $customer['ssn'],
			'zip' => $customer['zip'],
			'city' => $customer['city'],
			$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_DIV] => $customer['divisionid'],
			'div_name' => ($division['name'] ? $division['name'] : ''),
			'div_shortname' => ($division['shortname'] ? $division['shortname'] : ''),
			'div_address' => ($division['address'] ? $division['address'] : ''), 
			'div_city' => ($division['city'] ? $division['city'] : ''), 
			'div_zip' => ($division['zip'] ? $division['zip'] : ''),
			'div_' . $SYSLOG_RESOURCE_KEYS[SYSLOG_RES_COUNTRY] => ($division['countryid'] ? $division['countryid'] : 0),
			'div_ten'=> ($division['ten'] ? $division['ten'] : ''),
			'div_regon' => ($division['regon'] ? $division['regon'] : ''),
			'div_account' => ($division['account'] ? $division['account'] : ''),
			'div_inv_header' => ($division['inv_header'] ? $division['inv_header'] : ''),
			'div_inv_footer' => ($division['inv_footer'] ? $division['inv_footer'] : ''),
			'div_inv_author' => ($division['inv_author'] ? $division['inv_author'] : ''),
			'div_inv_cplace' => ($division['inv_cplace'] ? $division['inv_cplace'] : ''),
			$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_DOC] => $iid,
		);
		$DB->Execute('UPDATE documents SET cdate = ?, sdate = ?, paytime = ?, paytype = ?, customerid = ?,
				name = ?, address = ?, ten = ?, ssn = ?, zip = ?, city = ?, divisionid = ?,
				div_name = ?, div_shortname = ?, div_address = ?, div_city = ?, div_zip = ?, div_countryid = ?,
				div_ten = ?, div_regon = ?, div_account = ?, div_inv_header = ?, div_inv_footer = ?,
				div_inv_author = ?, div_inv_cplace = ?
				WHERE id = ?', array_values($args));
		if ($SYSLOG)
			$SYSLOG->AddMessage(SYSLOG_RES_DOC, SYSLOG_OPER_UPDATE, $args,
				array($SYSLOG_RESOURCE_KEYS[SYSLOG_RES_DOC], $SYSLOG_RESOURCE_KEYS[SYSLOG_RES_CUST],
					$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_DIV], 'div_' . $SYSLOG_RESOURCE_KEYS[SYSLOG_RES_COUNTRY]));

		if (!$invoice['closed']) {
			if ($SYSLOG) {
				$cashids = $DB->GetCol('SELECT id FROM cash WHERE docid = ?', array($iid));
				foreach ($cashids as $cashid) {
					$args = array(
						$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_CASH] => $cashid,
						$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_DOC] => $iid,
						$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_CUST] => $customer['id'],
					);
					$SYSLOG->AddMessage(SYSLOG_RES_CASH, SYSLOG_OPER_DELETE, $args,
						array_keys($args));
				}
				$itemids = $DB->GetCol('SELECT itemid FROM invoicecontents WHERE docid = ?', array($iid));
				foreach ($itemids as $itemid) {
					$args = array(
						$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_DOC] => $iid,
						$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_CUST] => $customer['id'],
						'itemid' => $itemid,
					);
					$SYSLOG->AddMessage(SYSLOG_RES_INVOICECONT, SYSLOG_OPER_DELETE, $args,
						array($SYSLOG_RESOURCE_KEYS[SYSLOG_RES_DOC], $SYSLOG_RESOURCE_KEYS[SYSLOG_RES_CUST]));
				}
			}
			$DB->Execute('DELETE FROM invoicecontents WHERE docid = ?', array($iid));
			$DB->Execute('DELETE FROM cash WHERE docid = ?', array($iid));

			$itemid=0;
			foreach ($contents as $idx => $item) {
				$itemid++;

				$args = array(
					$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_DOC] => $iid,
					'itemid' => $itemid,
					'value' => $item['valuebrutto'],
					$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_TAX] => $item['taxid'],
					'prodid' => $item['prodid'],
					'content' => $item['jm'],
					'count' => $item['count'],
					'pdiscount' => $item['pdiscount'],
					'vdiscount' => $item['vdiscount'],
					'name' => $item['name'],
					$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_TARIFF] => $item['tariffid'],
				);
				$DB->Execute('INSERT INTO invoicecontents (docid, itemid, value,
					taxid, prodid, content, count, pdiscount, vdiscount, description, tariffid)
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array_values($args));
				if ($SYSLOG) {
					$args[$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_CUST]] = $customer['id'];
					$SYSLOG->AddMessage(SYSLOG_RES_INVOICECONT, SYSLOG_OPER_ADD, $args,
						array($SYSLOG_RESOURCE_KEYS[SYSLOG_RES_DOC], $SYSLOG_RESOURCE_KEYS[SYSLOG_RES_TAX],
							$SYSLOG_RESOURCE_KEYS[SYSLOG_RES_TARIFF], $SYSLOG_RESOURCE_KEYS[SYSLOG_RES_CUST]));
				}

				$LMS->AddBalance(array(
					'time' => $cdate,
					'value' => $item['valuebrutto']*$item['count']*-1,
					'taxid' => $item['taxid'],
					'customerid' => $customer['id'],
					'comment' => $item['name'],
					'docid' => $iid,
					'itemid' => $itemid
					));
			}
		}

		$DB->CommitTrans();

		if (isset($_GET['print']))
			$SESSION->save('invoiceprint', array('invoice' => $invoice['id'],
				'original' => !empty($_GET['original']) ? 1 : 0,
			'copy' => !empty($_GET['copy']) ? 1 : 0,
				'duplicate' => !empty($_GET['duplicate']) ? 1 : 0));

		$SESSION->redirect('?m=invoicelist');
	break;
	
	case 'edit':
		// ADESCOM
                $date = strtotime("-1 month", $invoice['cdate']);
		
                $extraposition['fromdate'] = DateTimeHelper::parseDateArray(DateTimeHelper::dateTrunc($date, 'month', false));
                $extraposition['todate'] = DateTimeHelper::parseDateArray(DateTimeHelper::dateTrunc($date, 'month', true));
		// ADESCOM	
		break;	
}

$SESSION->save('invoice', $invoice);
$SESSION->save('invoicecontents', $contents);
$SESSION->save('invoicecustomer', $customer);
$SESSION->save('invoiceediterror', $error);

// ADESCOM
$SESSION->save('invoiceextraposition', $extraposition);
// ADESCOM

if($action != '')
{
	// redirect needed because we don't want to destroy contents of invoice in order of page refresh
	$SESSION->redirect('?m=invoiceedit');
}

if(!isset($CONFIG['phpui']['big_networks']) || !chkconfig($CONFIG['phpui']['big_networks']))
{
        $SMARTY->assign('customers', $LMS->GetCustomerNames());
}

// ADESCOM
$invoice_manager = new AdescomInvoiceManager();
$GLOBALS['EXTRAPOSITIONS'] = $extrapositions = $invoice_manager->getInvoiceExtraPositions();

function get_extra_position($type, $date_from, $date_to, $customer_id)
{
    $LMS = $GLOBALS['LMS'];
    $SMARTY = $GLOBALS['SMARTY'];
    $CONFIG = $GLOBALS['CONFIG'];
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
        foreach ($positions as & $position) {
            if ($position['subscribe']) {
                $name = $CONFIG['adescom']['invoice_position_subscribe'];

                $name = str_replace('%subscribe_period', date("m/Y", $position['period']), $name);
            } else {
                $name = $CONFIG['adescom']['invoice_position_calls'];

                $name = str_replace('%calls_fraction', $position['fraction'], $name);
                $name = str_replace('%calls_count', $position['count'], $name);
                $name = str_replace('%calls_periodfrom', date("Y/m/d", $date_from), $name);
                $name = str_replace('%calls_periodto', date("Y/m/d", $date_to), $name);
            }

            $position['name'] = $name;
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

$SESSION->restore('invoiceextraposition', $extraposition);

if ($extraposition == null) {
    $date = strtotime("-1 month", $invoice['cdate']);

    $extraposition['fromdate'] = parse_date_array(date_trunc($date, 'month', false));
    $extraposition['todate'] = parse_date_array(date_trunc($date, 'month', true));
}

$SESSION->save('invoiceextraposition', $extraposition);

$SMARTY->assign('extraposition', $extraposition);

$SMARTY->assign('xajax', $LMS->RunXajax());
$SMARTY->assign('adescom', true);
$SMARTY->assign('extrapositions', $extrapositions);
// ADESCOM

$SMARTY->assign('error', $error);
$SMARTY->assign('contents', $contents);
$SMARTY->assign('customer', $customer);
$SMARTY->assign('invoice', $invoice);
$SMARTY->assign('tariffs', $LMS->GetTariffs());
$SMARTY->assign('taxeslist', $taxeslist);
$SMARTY->display('invoice/invoiceedit.html');

?>
