<?php

$clid_limit_manager = new AdescomClidLimitManager();

try {
    $default_limits = $clid_limit_manager->getDefaultPostpaidLimits();
} catch (Exception $e) {
    error_log($e);
    $SESSION->redirect('?m=adescom_error');
}

$settings['default_absolute_cost_limit'] = $default_limits['absolute_limit'];

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$layout['pagetitle'] = trans('VOIP settings');

if (isset($_POST['settings'])) {
    $settings = $_POST['settings'];

    foreach ($settings as $key => $value) {
        $settings[$key] = trim($value);
    }

    if (array_key_exists('default_absolute_cost_limit', $settings)) {
        $settings['default_absolute_cost_limit'] = str_replace(',', '.', $settings['default_absolute_cost_limit']);
        if (!is_numeric($settings['default_absolute_cost_limit'])) {
            $error['default_absolute_cost_limit'] = trans('Default absolute cost limit must be a numeric value!');
        }
    }

    if (!$error) {
        try {
            if (array_key_exists('default_absolute_cost_limit', $settings)) {
                $clid_limit_manager->setDefaultPostpaidLimits(array('absolute_limit' => $settings['default_absolute_cost_limit'], 'relative_limit' => null));
            }
        } catch (Exception $e) {
            error_log($e);
            $SESSION->redirect('?m=adescom_error');
        }
        $SESSION->save('message', trans('Changes save successfully!'));
        $SESSION->redirect('?m=voipsettings');
    }
}

$SESSION->restore('message', $message);
if (!empty($message)) {
    $SESSION->remove('message');
    $SMARTY->assign('message', trans('Changes save successfully!'));
}

$SMARTY->assign('error', $error);
$SMARTY->assign('settings', $settings);
$SMARTY->display('voipaccount/voipsettings.html');
?>
