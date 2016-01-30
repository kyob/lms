<?php

$layout['pagetitle'] = trans('VOIP number pools list');

$pool_manager = new AdescomPoolManager();

$pools = $pool_manager->getAllPools();

$listdata['total'] = count($pools);

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$SMARTY->assign('pools', $pools);
$SMARTY->display('voipaccount/voippools.html');

