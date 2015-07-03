<?php
global $SMARTY, $LMS, $DB, $SESSION;

$lokalizacje = $DB->GetAll('SELECT location FROM vnodes WHERE ownerid = ?', array($customer));
if(!$lokalizacje)
{
    $errors[zawieszenie]='BŁĄD: Brak umów, więc nie można przypisać aneksu!';
}
if(isset($_POST['document']))
{
    
/* short example of errors handling

	$error['notes'] = 'Error';
	$result = 'Error';
	return;
*/
}
else // AJAX request
{
    // Variables accessible in AJAX request
    // $customer    - selected customer ID
    // $JSResponse  - xajaxResponse object
}
$SMARTY->assign(
        array(
            'lokalizacje' => $lokalizacje,
            'errors' => $errors,            
        )
);

$result = $SMARTY->fetch(DOC_DIR.'/templates/'.$engine['name'].'/plugin.html');

?>
