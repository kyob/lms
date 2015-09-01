<?php
 
function getFirstYear() {
    global $LMS, $SMARTY, $DB, $SESSION;
    $firstYear = $DB->GetOne('SELECT MIN( creationdate ) FROM customers');
    return $firstYear;
}
 
function newCustomers($year) {
    global $LMS, $SMARTY, $DB, $SESSION;
    $newcustomers = $DB->GetAll('
    SELECT COUNT(id) AS suma, MONTH(FROM_UNIXTIME(creationdate)) as month
    FROM customers
    WHERE deleted=0 AND YEAR(FROM_UNIXTIME(creationdate))=' . $year . ' 
    GROUP BY MONTH(FROM_UNIXTIME(creationdate))
    ');
    return $newcustomers;
}
 
function deletedCustomers($year) {
    global $LMS, $SMARTY, $DB, $SESSION;
    $deletedcustomers = $DB->GetAll('
    SELECT COUNT(id) AS suma, MONTH(FROM_UNIXTIME(moddate)) as month
    FROM customers
    WHERE deleted=1 AND YEAR(FROM_UNIXTIME(moddate))=' . $year . ' 
    GROUP BY MONTH(FROM_UNIXTIME(moddate))
    ');
    return $deletedcustomers;
}
 
function GetUserID() {
    global $SESSION;
    return $SESSION->_content[session_id];
}
 
if (!$_GET['year'] > 0)
    $_GET['year'] = date("Y", mktime());
 
 
 
$newcustomers = newCustomers($_GET['year']);
foreach ($newcustomers as $item) {
    $month = $month . "'" . date("M", mktime(0, 0, 0, $item['month'])) . "',";
    $sum = $sum . $item['suma'] . ',';
}

$SMARTY->assign('month', "''," . substr($month, 0, -1));
$SMARTY->assign('sum', "''," . substr($sum, 0, -1));
$SMARTY->assign('newcustomers', newCustomers($_GET['year']));
 
 
 
$deletedcustomers = deletedCustomers($_GET['year']);
foreach ($deletedcustomers as $item) {
    $month2 = $month2 . "'" . date("M", mktime(0, 0, 0, $item['month'])) . "',";
    $sum2 = $sum2 . $item['suma'] . ',';
}
$SMARTY->assign('month2', "''," . substr($month2, 0, -1));
$SMARTY->assign('sum2', "''," . substr($sum2, 0, -1));
$SMARTY->assign('deletedcustomers', deletedCustomers($_GET['year']));
 
 
 
for ($m = 0; $m < 12; $m++) {
    $bilans[] = array('month' => $m+1, 'suma' => $newcustomers[$m]['suma'] - $deletedcustomers[$m]['suma']);
}
//echo '<pre>';print_r($bilans);
 
foreach ($bilans as $item) {
    $month3 = $month3 . "'" . date("M", mktime(0, 0, 0, $item['month'])) . "',";
    $sum3 = $sum3 . $item['suma'] . ',';
}
//echo '<pre>';die(print_r($month3));

$SMARTY->assign('month3', "''," . substr($month3, 0, -1));
$SMARTY->assign('sum3', "''," . substr($sum3, 0, -1));
 
 
 
 
$SMARTY->assign('user', GetUserID());
$SMARTY->assign('firstYear', date("Y", getFirstYear()));
$SMARTY->assign('currentYear', date("Y", mktime()));
$SMARTY->display('alfa_newcustomersstats.html');
?>