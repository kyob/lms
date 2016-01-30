<?php

if (!$LMS->VoipAccountExists($_GET['id'])) {
    if (isset($_GET['ownerid'])) {
        header('Location: ?m=customerinfo&id=' . $_GET['ownerid']);
    } else {
        header('Location: ?m=voipaccountlist');
    }
}

$voipaccountid = intval($_GET['id']);

$customerid = $LMS->GetVoipAccountOwner($voipaccountid);

if ($customerid == null) {
    header('Location: ?m=voipaccountlist');
}

$customer = $LMS->GetCustomer($customerid);

if ($customerid == false) {
    header('Location: ?m=voipaccountlist');
}

$voipaccountinfo = $LMS->GetVoipAccount($voipaccountid);

if ($voipaccountinfo == null) {
    header('Location: ?m=voipaccountlist');
}

$customer_name = $LMS->GetCustomerName($customerid);
$address = $customer['address'] . ' ' . $customer['zip'] . ' ' . $customer['city'] . ' ' . trans($LMS->GetCountryName($customer['countryid']));

$clid_manager = new AdescomClidManager();
$ctm_manager = new AdescomCTMManager();
$phone_manager = new AdescomPhoneManager();
$tariff_manager = new AdescomTariffManager();

$clid = $clid_manager->getClid($voipaccountinfo['phone']);

if ($clid == null) {
    header('Location: ?m=voipaccountlist');
}

$ctms = $ctm_manager->getCTMNodes($connection);
$phones = $phone_manager->getPhones($connection);
$tariffs = $tariff_manager->getTariffs($connection);

$phoneid = $clid['phoneid'];
$ctmid = $clid['ctmid'];
$tariffid = $clid['tariffid'];

$callerid = $clid['callerid'];
$password = $clid['passwd'];
$mac = $clid['mac_address'];
$serial = $clid['serial_number'];
$line = $clid['line'];
$context = $clid['context'];
$ctm_name = null;
foreach ($ctms as $ctm) {
    if ($ctm['id'] === $ctmid) {
        $ctm_name = $ctm['name'];
        break;
    }
}
$phone = array_key_exists($phoneid, $phones) ? $phones[$phoneid]['name'] : null;
$tariff = null;

switch ($clid['registration_type']) {
    case 'country+area+local':
        $login = $clid['countrycode'] . $clid['areacode'] . $clid['shortclid'];
        break;
    case 'area+local':
        $login = $clid['areacode'] . $clid['shortclid'];
        break;
    case 'local':
        $login = $clid['shortclid'];
        break;
    default:
        $login = $clid['areacode'] . $clid['shortclid'];
        break;
}

foreach ($tariffs as $t) {
    if ($t['id'] == $tariffid) {
        $tariff = $t['name'];
        break;
    }
}

$no_data = trans('No data');

$SMARTY->assign('customer', empty($customer_name) ? $no_data : $customer_name);
$SMARTY->assign('address', empty($address) ? $no_data : $address);

$SMARTY->assign('callerid', empty($callerid) ? $no_data : $callerid);
$SMARTY->assign('login', empty($login) ? $no_data : $login);
$SMARTY->assign('pass', empty($password) ? $no_data : $password);
$SMARTY->assign('mac', empty($mac) ? $no_data : $mac);
$SMARTY->assign('serial', empty($serial) ? $no_data : $serial);
$SMARTY->assign('ctm', empty($ctm_name) ? $no_data : $ctm_name);
$SMARTY->assign('phone', empty($phone) ? $no_data : $phone);
$SMARTY->assign('line', empty($line) ? $no_data : $line);
$SMARTY->assign('tariff', empty($tariff) ? $no_data : $tariff);
$SMARTY->assign('context', empty($context) ? $no_data : $context);

$SMARTY->assign('css', 'img/style_print_voipphone.css');
$SMARTY->display('voipaccount/voipaccountprint.html');
