<?php

$voippooladd = isset($_POST['voippooladd']) ? $_POST['voippooladd'] : NULL;

if (sizeof($voippooladd)) {
    foreach ($voippooladd as $idx => $key) {
        $voippooladd[$idx] = trim($key);
    }

    if ($voippooladd['name'] == '') {
        $error['name'] = trans('VOIP pool name is required!');
    } elseif (strlen($voippooladd['name']) > 50) {
        $error['name'] = trans('Name is too long (max. 50 characters)!');
    }

    if (!is_numeric($voippooladd['countrycode'])) {
        $error['countrycode'] = trans('Country code value is not integer!');
    } elseif ($voippooladd['countrycode'] < 0 || $voippooladd['countrycode'] > 99 || strlen($voippooladd['countrycode']) != 2) {
        $error['countrycode'] = trans('Incorrect country code value!');
    }

    if (!is_numeric($voippooladd['areacode'])) {
        $error['areacode'] = trans('Area code value is not integer!');
    } elseif ($voippooladd['areacode'] < 0 || $voippooladd['areacode'] > 99 || strlen($voippooladd['areacode']) != 2) {
        $error['areacode'] = trans('Incorrect area code value!');
    }

    if (!is_numeric($voippooladd['fromnumber'])) {
        $error['fromnumber'] = trans('From number value is not integer!');
    } elseif ($voippooladd['fromnumber'] < 0) {
        $error['fromnumber'] = trans('Incorrect from number code value!');
    }

    if (!is_numeric($voippooladd['tonumber'])) {
        $error['tonumber'] = trans('To number value is not integer!');
    } elseif ($voippooladd['tonumber'] < 0) {
        $error['tonumber'] = trans('Incorrect to number code value!');
    }

    if ($voippooladd['tonumber'] < $voippooladd['fromnumber']) {
        $error['tonumber'] = trans('To number value must be bigger then from number value!');
    }

    if (!$error) {
        $pool_manager = new AdescomPoolManager();
        $pool_manager->addPool($voippooladd);

        if (!isset($voippooladd['reuse'])) {
            $SESSION->redirect('?m=voippools');
        }
        unset($voippooladd['label']);
        unset($voippooladd['value']);
        unset($voippooladd['validfrom']);
        unset($voippooladd['validto']);
    }
}

$layout['pagetitle'] = trans('New VOIP numbers pool');

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$SMARTY->assign('voippooladd', $voippooladd);
$SMARTY->assign('error', $error);
$SMARTY->display('voipaccount/voippooladd.html');
