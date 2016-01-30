<?php

/*
 * LMS version 1.11-cvs
 *
 *  (C) Copyright 2001-2010 LMS Developers
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
 *  $Id: customerlist.php,v 1.13 2010/03/11 13:07:45 alec Exp $
 */

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$layout['pagetitle'] = trans('Billing records');

if(! isset($_GET['nr']))
	$SESSION->restore('nr', $trunknr);
else
	$trunknr = $_GET['nr'];
$SESSION->save('nr', $trunknr);

if ($trunknr === null)
	$SESSION->redirect('?m=voiptrunklist');

if(isset($_GET['page']))
	$page = $_GET['page'];
else
	$page = 1;

if ($page < 1)
	$page = 1;

$pagelimit = 20;
	
try
{
	$connection = $ADESCOM_LMS->connect();
}	
catch (Exception $e)
{
	error_log($e);
	
	$SESSION->redirect('?m=adescomsystemdown');
}

if (isset($_POST['filter']))
	$filter = $_POST['filter'];
else if (! isset($_GET['reset']))
	$SESSION->restore('filter', $filter);

if (! isset($filter))
{
	$now = time();

	$filter['incoming'] = false;
	$filter['outgoing'] = true;
	$filter['remotenumber'] = null;
	$filter['fromdate'] = date('Y/m/d H:i:s', strtotime("-1 month", $now));
	$filter['todate'] = date('Y/m/d H:i:s', $now);
	$filter['includezero'] = false;
}
$SESSION->save('filter', $filter);

if (! isset($filter['fromdate']))
	$error['fromdate'] = trans('Date/time is required!');
else
{
	$from_date = strtotime($filter['fromdate']);
	
	if (! $from_date)
		$error['fromdate'] = trans('Invalid value!');	
}

if (! isset($filter['todate']))
	$error['todate'] = trans('Date/time is required!');
else
{
	$to_date = strtotime($filter['todate']);
	
	if (! $to_date)
		$error['todate'] = trans('Invalid value!');	
}

$response = null;

if (! $error)
{
	$order_by = new StdClass();
	
	$order_by->items[] = array('name' => 'startDate', 'descending' => true);

	if (! empty($filter['remotenumber']))
		$options['remoteMask'] = $filter['remotenumber'];
	
	$options['incoming'] = array_get_value('incoming', $filter, false);
	$options['outgoing'] = array_get_value('outgoing', $filter, false);
	$options['includeZeroDuration'] = array_get_value('includezero', $filter, false);
	$options['page'] = $page - 1;
	$options['perPage'] = $pagelimit;
	$options['orderBy'] = $order_by;
	$options['countCDRs'] = true;
	$options['sumCDRs'] = true;

	try
	{
		$response = $ADESCOM_LMS->getBillingForTrunk($trunknr, $from_date, $to_date, $options);
	}
	catch (SoapFault $e)
	{
		switch ($e->detail->code)
		{
			case 'trunk_not_found':
				$error['remotenumber'] = trans('Trunk not found!');
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

if ($total > 0)
{
	$records = array_fill(0, $total, null);

	for ($i = 0; $i < count($items); $i++)
		$records[$start + $i] = $items[$i];
}

$listdata['total'] = $total;
$listdata['totalPrice'] = $totalPrice;
$listdata['totalDuration'] = $totalDuration;

$SMARTY->assign('summary', $cdrs_summary);
$SMARTY->assign('records', $records);
$SMARTY->assign('listdata',$listdata);
$SMARTY->assign('pagelimit', $pagelimit);
$SMARTY->assign('page', $page);
$SMARTY->assign('start', $start);
$SMARTY->assign('filter', $filter);
$SMARTY->assign('error', $error);

$SMARTY->display('trunkbillinglist.html');
?> 