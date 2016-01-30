<?php
global $LMS,$SMARTY,$SESSION,$DB;

//$SMARTY->debugging = true;

include('libs/billing.lib.php');

$billing = new Billing;

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'form';
switch($_action) {
    case 'submit':
        // submitting a billing entry
        $billing->mungeFormData($_POST);
        if($billing->isValidForm($_POST)) {
            $billing->displayBilling($billing->getBilling($_POST), $_POST);
        } else {
            $billing->displayForm($_POST);
        }

        break;
    case 'form':
    default:
        // viewing the form
        $billing->displayForm($_POST);
        break;
}


?>
