<?php

$layout['pagetitle'] = trans('Voip Trunks List');

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$trunk_manager = new AdescomTrunkManager();

try {
    $trunks = $trunk_manager->getTrunks($total);
} catch (Exception $e) {
    error_log($e);
    $SESSION->redirect('?m=adescom_error');
}

$SMARTY->assign('total', $total);
$SMARTY->assign('trunks', $trunks);

$SMARTY->display('voipaccount/voiptrunklist.html');

