<?php

if (!isset($_GET['ref'])) {
    $SESSION->restore('pool_search_ref', $ref);
} else {
    $ref = $_GET['ref'];
}

$SESSION->restore('voipaccountdata', $voipaccountdata);

$voipaccountdata['countrycode'] = $_GET['cc'];
$voipaccountdata['areacode'] = $_GET['ac'];
$voipaccountdata['shortclid'] = $_GET['sc'];

$SESSION->save('voipaccountdata', $voipaccountdata);

$SESSION->redirect($ref);
