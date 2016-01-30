<?php
global $LMS,$SMARTY,$SESSION,$DB;

//$SMARTY->debugging = true;

include('libs/billing.lib.php');

$billing = new Billing;

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'form';
switch($_action) {
    case 'submit':

        // submitting doladuj
        if($billing->isValidFormUstawienia($_POST)) {
//            $billing->displayFormUstawienia($_POST);
            $billing->displayUstawienia($billing->zmienUstawienia($_POST), $_POST);
        } else {
            $billing->displayFormUstawienia($_POST);
        }

        break;
    case 'form':
    default:
        // viewing the form
        $billing->displayFormUstawienia($_POST);
        break;
}


?>