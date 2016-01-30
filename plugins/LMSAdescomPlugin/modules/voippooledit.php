<?php
$pool_manager = new AdescomPoolManager();

$pool = $pool_manager->getPool($_GET['id']);

if (!$pool) {
    $SESSION->redirect('?m=voippools');
}

$voippooledit = isset($_POST['voippooledit']) ? $_POST['voippooledit'] : NULL;

if (sizeof($voippooledit)) {
    foreach ($voippooledit as $idx => $key)
        $voippooledit[$idx] = trim($key);

    $voippooledit['id'] = $pool['id'];

    if ($voippooledit['name'] == '')
        $error['name'] = trans('VOIP pool name is required!');
    elseif (strlen($voippooledit['name']) > 50)
        $error['name'] = trans('Name is too long (max. 50 characters)!');

    if (!is_numeric($voippooledit['countrycode']))
        $error['countrycode'] = trans('Country code value is not integer!');
    elseif ($voippooledit['countrycode'] < 0)
        $error['countrycode'] = trans('Incorrect country code value!');

    if (!is_numeric($voippooledit['areacode']))
        $error['areacode'] = trans('Area code value is not integer!');
    elseif ($voippooledit['areacode'] < 0)
        $error['areacode'] = trans('Incorrect area code value!');

    if (!is_numeric($voippooledit['fromnumber']))
        $error['fromnumber'] = trans('From number value is not integer!');
    elseif ($voippooledit['fromnumber'] < 0)
        $error['fromnumber'] = trans('Incorrect from number code value!');

    if (!is_numeric($voippooledit['tonumber']))
        $error['tonumber'] = trans('To number value is not integer!');
    elseif ($voippooledit['tonumber'] < 0)
        $error['tonumber'] = trans('Incorrect to number code value!');

    if ($voippooledit['tonumber'] < $voippooledit['fromnumber'])
        $error['tonumber'] = trans('To number value must be bigger then from number value!');

    if (!$error) {
        $pool_manager->savePool($voippooledit);

        $SESSION->redirect('?m=voippools');
    } else
        $pool = $voippooledit;
}

$layout['pagetitle'] = trans('Edit VOIP numbers pool: $a', $pool['name']);

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$SMARTY->assign('voippooledit', $pool);
$SMARTY->assign('error', $error);
$SMARTY->display('voipaccount/voippooledit.html');
