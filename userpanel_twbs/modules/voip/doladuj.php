<?php
global $LMS,$SMARTY,$SESSION,$DB;

//$SMARTY->debugging = true;

include('libs/billing.lib.php');

$billing = new Billing;

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'form';
switch($_action) {
    case 'submit':
        // submitting doladuj
        if($billing->isValidFormDoladuj($_POST)) {
            $billing->displayDoladuj($_POST);
        } else {
            $billing->displayFormDoladuj($_POST);
        }
        break;

    case 'clear':
	    // debug - wyczysc dokumenty klienta od daty zdefiniowanej w funkcji - produkcyjnie KONIECZNIE zakomentowac ;-)
            $billing->displayFormDoladuj($_POST);
    //        $billing->_czyscDane();
        break;
    case 'form':
    default:
        // viewing the form
        $billing->displayFormDoladuj($_POST);
        break;
}


?>