<?php

global $SMARTY, $LMS, $DB, $SESSION;

$fixlink = "http://lms2.alfa-system.pl/?m=customeredit&id=";
$nodes = 0;
if (isset($_POST['document'])) {
    $ci = $LMS->GetCustomer($document['customerid']);
//echo 'CI<pre>'; print_r($ci); echo '</pre>';

    $ca = $LMS->GetCustomerAssignments($document['customerid']);
//echo 'CA<pre>'; print_r($ca); echo '</pre>';

    $cn = $LMS->GetCustomerNodes($document['customerid']);
//echo 'CN<pre>'; print_r($cn); echo '</pre>';


    foreach ($cn as $item) {
        if ($item['location'])
            $nodes++;
    }

    if ($nodes != count($cn))
        $error['nodes'] = '<h1><a href="' . $fixlink . $document['customerid'] . '">UZUPEŁNIJ ADRES INSTALACJI PRZY KOMPUTERACH</a></h1>';

//    if (!$ci['email'])
//        $error['email'] = '<h1><a href="' . $fixlink . $document['customerid'] . '">BRAK EMAIL</a></h1>';

    if (!$ci['ssn'] and $ci['type'] == 0)
        $error['ssn'] = '<h1><a href="' . $fixlink . $document['customerid'] . '">BRAK PESEL</a></h1>';

    if (!$ci['ten'] and $ci['type'] == 1)
        $error['ten'] = '<h1><a href="' . $fixlink . $document['customerid'] . '">BRAK NIP</a></h1>';

    if (!(count($ca) > 0))
        $error['taryfy'] = '<h1>BRAK PRZYPISANYCH TARYF</h1>';

    //$error['notes'] = 'Error notes';
    $result = $error['nodes'] . $error['email'] . $error['ssn'] . $error['ten'] . $error['taryfy'];
    return;
}
else { // AJAX request
    // Variables accessible in AJAX request
    // $customer    - selected customer ID
    // $JSResponse  - xajaxResponse object
}
    $adresy_instalacji = $LMS->GetCustomerNodes($customer);
    foreach ($adresy_instalacji as $item) {
        if ($item['location'])
           $adresy['lokalizacja'][]=$item['location'];
    }
$SMARTY->assign(
        array(
            'adresy' => $adresy_instalacji,
        )
);



$result = $SMARTY->fetch(DOC_DIR . '/templates/' . $engine['name'] . '/plugin.html');
?>
