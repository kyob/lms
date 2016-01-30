<?php
global $SMARTY, $LMS, $DB, $SESSION;

$umowy = $DB->GetAll('SELECT number,cdate FROM documents WHERE customerid=? AND type=-1', array($customer));
if($umowy)
{
    foreach ($umowy as $umowa) {
        $contracts[] = $umowa[number].'/'.date("n", $umowa[cdate]).'/'.date("Y", $umowa[cdate]).'|'.date("j", $umowa[cdate]).'/'.date("m", $umowa[cdate]).'/'.date("Y", $umowa[cdate]);
    }
}else{
    $errors[aneks]='BŁĄD: Brak umów, więc nie można zrezygnować!';
}

if (isset($_POST['document'])) {
    /* short example of errors handling

      $error['notes'] = 'Error';
      $result = 'Error';
      return;
     */
} else { // AJAX request
    // Variables accessible in AJAX request
    // $customer    - selected customer ID
    // $JSResponse  - xajaxResponse object
}

$SMARTY->assign(
        array(
            'contracts' => $contracts,
            'errors' => $errors,
            'current_year' => date('Y'),
            'next_year' => date('Y', strtotime('+1 year')),
        )
);

$result = $SMARTY->fetch(DOC_DIR . '/templates/' . $engine['name'] . '/plugin.html');
?>
