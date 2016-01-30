<?php

global $LMS,$SMARTY,$SESSION,$DB;

$userinfo = $LMS->GetCustomer($SESSION->id);

$client_manager = new AdescomClientManager();
$username = $client_manager->getClient($SESSION->id);

$SMARTY->assign('username', $SESSION->id);
$SMARTY->assign('extUsername', $username['clientid']);

//podsumowanie polaczen dla ostanich 12 miesiecy
include('libs/billing.lib.php');
$billing = new Billing;

$opt = new stdClass();
$opt->incoming=false;
$opt->outgoing=true;
$opt->includeZeroDuration=false;
$opt->separatePeriods=false;

//pierwszy dzien z 3 miesiaca do tylu ;-)
$dataPocz = date("Y-m-d", mktime(0, 0, 0, date("m")-3, 1, date("Y")));
$dataDzis = date("Y-m-d");

$repPods = $billing->getReportSum($SESSION->id,$dataPocz,$dataDzis, $opt);
$clidsStatus=$billing->getClidsStatus();

$SMARTY->assign('rep', $repPods);
$SMARTY->assign('clidsStatus', $clidsStatus);
$SMARTY->display('module:main.html');

?>