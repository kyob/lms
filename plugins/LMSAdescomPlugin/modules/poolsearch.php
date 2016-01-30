<?php

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$layout['pagetitle'] = trans('Pool numbers');

if (!isset($_GET['pool'])) {
    $SESSION->restore('poolid', $poolid);
} else {
    $poolid = $_GET['pool'];
}
$SESSION->save('poolid', $poolid);

if (!isset($_GET['filter'])) {
    $SESSION->restore('filter', $filter);
} else {
    $filter = $_GET['filter'];
}
$SESSION->save('filter', $filter);

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

if ($page < 1) {
    $page = 1;
}

$cols = 8;
$rows = 20;

$pagelimit = $rows * $cols;

$options['page'] = $page;
$options['per_page'] = $pagelimit;

try {
    $pool_manager = new AdescomPoolManager();
    $numbers = $pool_manager->getPoolFreeNumbers($poolid, $total, $options);
} catch (Exception $e) {
    error_log($e);
    $SESSION->redirect('?m=adescom_error');
}

$start = ($page - 1) * $pagelimit;

if ($total > 0) {
    $results = array_fill(0, $total, null);
} else {
    $results = array();
}

for ($i = 0; $i < count($numbers); $i++) {
    $results[$start + $i] = $numbers[$i];
}

$listdata['total'] = $total;

$SMARTY->assign('results', $results);
$SMARTY->assign('listdata', $listdata);
$SMARTY->assign('pagelimit', $pagelimit);
$SMARTY->assign('page', $page);
$SMARTY->assign('start', $start);
$SMARTY->assign('cols', $cols);
$SMARTY->assign('rows', $rows);

$SMARTY->display('voipaccount/poolsearch.html');
