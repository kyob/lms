<?php

/*
 *  LMS version 1.11-git
 *
 *  Copyright (C) 2001-2013 LMS Developers
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

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$layout['pagetitle'] = trans('Billing records');

if (!isset($_GET['id']))
    $SESSION->restore('id', $clientid);
else
    $clientid = $_GET['id'];
$SESSION->save('id', $clientid);

if ($clientid === null)
    $SESSION->redirect('?m=voipaccountlist');

if (isset($_GET['page']))
    $page = $_GET['page'];
else
    $page = 1;

if ($page < 1)
    $page = 1;

$pagelimit = 20;

$voip_accounts = $LMS->GetCustomerVoipAccounts($clientid);

try {
    $trunk_manager = new AdescomTrunkManager();
    $trunks = $trunk_manager->getTrunksForClient($clientid);
} catch (Exception $e) {
    error_log($e);
    $SESSION->redirect('?m=adescom_error');
}

$trunk_names = array();

foreach ($trunks as $trunk)
    $trunk_names[$trunk['nr']] = $trunk['name'];

if (isset($_POST['filter'])) {
    if ($_POST['filter']['incoming'] === 'on') {
        $_POST['filter']['incoming'] = true;
    }
    if ($_POST['filter']['outgoing'] === 'on') {
        $_POST['filter']['outgoing'] = true;
    }
    $filter = $_POST['filter'];
} else if (!isset($_GET['reset']))
    $SESSION->restore('filter', $filter);

if (!isset($filter)) {
    $now = time();

    $filter['incoming'] = false;
    $filter['outgoing'] = true;
    $filter['remotenumber'] = null;
    $filter['fromdate'] = date('Y/m/01 00:00:00', $now);
    $filter['todate'] = date('Y/m/t 23:59:59', $now);
    $filter['includezero'] = false;

    if (isset($_GET['phone']))
        $filter['localnumber'] = array($_GET['phone']);
    else
        $filter['localnumber'] = true;
}
$SESSION->save('filter', $filter);

if (!isset($filter['fromdate']))
    $error['fromdate'] = trans('Date/time is required!');
else {
    $from_date = strtotime($filter['fromdate']);

    if (!$from_date)
        $error['fromdate'] = trans('Invalid value!');
}

if (!isset($filter['todate']))
    $error['todate'] = trans('Date/time is required!');
else {
    $to_date = strtotime($filter['todate']);

    if (!$to_date)
        $error['todate'] = trans('Invalid value!');
}

$response = null;

if (!$error) {
    $local_number = ArrayHelper::arrayGetValue('localnumber', $filter);
    $local_trunk = ArrayHelper::arrayGetValue('localtrunk', $filter);

    if (is_array($local_number))
        $clids_range = $filter['localnumber'];
    else if ($local_number === true) {
        $clids_range = array();

        if (is_array($voip_accounts['accounts'])) {
            foreach ($voip_accounts['accounts'] as $voip_account)
                $clids_range[] = $voip_account['phone'];
        }
    } else
        $clids_range = array();

    if (is_array($local_trunk))
        $trunks_range = $filter['localtrunk'];
    else if ($local_trunk === true) {
        $trunks_range = array();

        foreach ($trunks as $trunk)
            $trunks_range[] = $trunk['nr'];
    } else
        $trunks_range = array();

    if (!empty($filter['remotenumber']))
        $options['remoteMask'] = $filter['remotenumber'];

    $order_by = new StdClass();

    $order_by->items[] = array('name' => 'startDate', 'descending' => true);

    $options['incoming'] = ArrayHelper::arrayGetValue('incoming', $filter, false);
    $options['outgoing'] = ArrayHelper::arrayGetValue('outgoing', $filter, false);
    $options['includeZeroDuration'] = ArrayHelper::arrayGetValue('includezero', $filter, false);
    $options['page'] = $page - 1;
    $options['perPage'] = $pagelimit;
    $options['clientExtra'] = array('clids' => $clids_range, 'trunks' => $trunks_range);
    $options['orderBy'] = $order_by;
    $options['countCDRs'] = true;
    $options['sumCDRs'] = true;

    try {
        $billing_manager = new AdescomBillingManager();
        $response = $billing_manager->getBillingForClient($clientid, $from_date, $to_date, $options);
    } catch (SoapFault $e) {
        switch ($e->detail->code) {
            case 'clid_not_found':
                $error['localnumber'] = trans('Invalid value!');
                break;
            default:
                error_log($e);

                $SESSION->redirect('?m=adescom_error');
                break;
        }
    }
}

$total = $response ? $response->total : 0;
$totalPrice = $response ? $response->totalPrice : 0;
$totalDuration = $response ? $response->totalDuration : 0;
$items = $response ? $response->items : array();
$start = ($page - 1) * $pagelimit;

if ($total > 0) {
    $records = array_fill(0, $total, null);

    for ($i = 0; $i < count($items); $i++)
        $records[$start + $i] = $items[$i];
}

$listdata['total'] = $total;
$listdata['totalPrice'] = $totalPrice;
$listdata['totalDuration'] = $totalDuration;

$SMARTY->assign('records', $records);
$SMARTY->assign('listdata', $listdata);
$SMARTY->assign('pagelimit', $pagelimit);
$SMARTY->assign('page', $page);
$SMARTY->assign('start', $start);
$SMARTY->assign('voipaccounts', $voip_accounts['accounts']);
$SMARTY->assign('trunks', $trunks);
$SMARTY->assign('trunknames', $trunk_names);
$SMARTY->assign('filter', $filter);
$SMARTY->assign('error', $error);

$SMARTY->display('billinglist.html');
