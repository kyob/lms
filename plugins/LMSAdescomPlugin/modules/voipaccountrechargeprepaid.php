<?php

if (!$LMS->VoipAccountExists($_GET['id'])) {
    if (isset($_GET['ownerid'])) {
        header('Location: ?m=customerinfo&id=' . $_GET['ownerid']);
    } else {
        header('Location: ?m=voipaccountlist');
    }
}

$voipaccountid = intval($_GET['id']);

$voipaccountinfo = $LMS->GetVoipAccount($voipaccountid);

$clid_manager = new AdescomClidManager();
$clid_limit_manager = new AdescomClidLimitManager();

try {
    $voipdetails = $clid_manager->getCLID($voipaccountinfo['phone']);
    $prepaid_state = $clid_limit_manager->getCLIDPrepaidAccountState($voipaccountinfo['phone']);
} catch (Exception $e) {
    error_log($e);
    $SESSION->redirect('?m=adescom_error');
}

if (!isset($prepaid_state['value']) || !is_numeric($prepaid_state['value'])) {
    $prepaid_state['value'] = 0;
}

$voipaccountinfo['prepaid_state'] = $prepaid_state['value'];

$voipaccountinfo = array_merge($voipaccountinfo, $voipdetails);

if (!$voipaccountinfo['is_prepaid']) {
    if (isset($_GET['ownerid'])) {
        header('Location: ?m=customerinfo&id=' . $_GET['ownerid']);
    } else {
        header('Location: ?m=voipaccountlist');
    }
}

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$layout['pagetitle'] = trans('Recharge prepaid VOIP account: $a', $voipaccountinfo['login']);

if (isset($_POST['voipaccount'])) {
    $SESSION->restore('voip_account_recharge_inner_ref', $ref);

    $voipaccount = $_POST['voipaccount'];

    foreach ($voipaccount as $key => $value) {
        $voipaccount[$key] = trim($value);
    }

    if (empty($voipaccount['amount'])) {
        $error['amount'] = trans('You must enter VOIP account prepaid recharge amount!');
    } else {
        $voipaccount['amount'] = str_replace(',', '.', $voipaccount['amount']);
        if (!is_numeric($voipaccount['amount'])) {
            $error['amount'] = trans('VOIP account prepaid recharge amount must be a numeric value!');
        }
    }

    if (!$error) {
        try {
            $prepaidstate['value'] = $voipaccount['amount'];

            $clid_limit_manager->addCLIDPrepaidAccountState($voipaccountinfo['phone'], $prepaidstate);

            if ($ref) {
                $SESSION->remove('voip_account_recharge_inner_ref');

                $SESSION->restore('voipaccountdata', $voipaccountdata);

                if ($voipaccountdata) {
                    $prepaid_state = $clid_limit_manager->getCLIDPrepaidAccountState($voipaccountinfo['phone']);

                    if (isset($prepaid_state['value'])) {
                        $voipaccountdata['prepaid_state'] = $prepaid_state['value'];
                    } else {
                        $voipaccountdata['prepaid_state'] = 0;
                    }

                    $SESSION->save('voipaccountdata', $voipaccountdata);
                }

                $SESSION->redirect($ref);
            } else {
                $SESSION->redirect('?m=voipaccountinfo&id=' . $voipaccountinfo['id']);
            }

            die;
        } catch (SoapFault $e) {
            switch ($e->detail->code) {
                case 'clid_not_found':
                    $error['phone'] = trans('Unable to find CLID!');
                    break;
                case 'unable_save_clid':
                    $error['phone'] = trans('Unable to save changes!');
                    break;
                default:
                    error_log($e);
                    $SESSION->redirect('?m=adescom_error');
                    break;
            }
        }
    }
} else {
    $SESSION->remove('voip_account_recharge_inner_ref');

    $SESSION->restore('charge_prepaid_ref', $ref);

    if ($ref) {
        $SESSION->remove('charge_prepaid_ref');

        $SESSION->save('voip_account_recharge_inner_ref', $ref);
    }
}

$SMARTY->assign('error', $error);
$SMARTY->assign('voipaccountinfo', $voipaccountinfo);
$SMARTY->assign('voipaccount', $voipaccount);
$SMARTY->assign('ref', $ref ? $ref : "?m=voipaccountinfo&id={$voipaccountinfo['id']}");
$SMARTY->display('voipaccount/voipaccountrechargeprepaid.html');
