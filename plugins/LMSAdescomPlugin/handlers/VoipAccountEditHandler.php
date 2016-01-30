<?php

/*
 *  LMS version 1.11-git
 *
 *  Copyright (C) 2001-2013 LMS Developers
 *
 *  Please, see the doc/AUTHORS for more information about authors!
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 *  $Id$
 */

/**
 * VoipAccountEditHandler
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class VoipAccountEditHandler extends VoipAccountHandlerAbstract
{

    private $xajax;
    
    /**
     * Triggers after phone is selected. Returns additional options.
     * 
     * @param int $phoneid Phone id
     * @param string $phone_line_templates Template name
     * @return \xajaxResponse Response
     */
    public function select_phone($phoneid, $phone_line_templates = null)
    {
        return parent::select_phone($phoneid, 'voipaccount/voipaccounteditlines.html');
    }

    /**
     * Adds some actions on load of VoIP account edit module
     * 
     * @global Smarty $SMARTY Smarty
     * @global Session $SESSION Session
     * @return null
     */
    public function voipAccountEditOnLoad()
    {
        global $SMARTY, $SESSION;

        $voipaccountid = intval($_GET['id']);

        if (isset($_POST['pool_search']) && $ownerid) {
            if (isset($_POST['voipaccountedit'])) {
                $SESSION->save('voipaccountdata', $_POST['voipaccountedit']);
            }

            $SESSION->save('pool_search_ref', '?m=voipaccountedit&id=' . $voipaccountid . '&return=true');

            $SESSION->redirect('?m=poolsearch&pool=' . $_POST['pool_search']);

            die();
        }
        
        if (isset($_POST['charge_prepaid'])) {
            if (isset($_POST['voipaccountedit'])) {
                $SESSION->save('voipaccountdata', $_POST['voipaccountedit']);
            }

            $SESSION->save('charge_prepaid_ref', '?m=voipaccountedit&id=' . $voipaccountid . '&return=true');

            $SESSION->redirect('?m=voipaccountrechargeprepaid&id=' . $voipaccountid);

            die();
        }

        require_once(LIB_DIR . '/xajax/xajax_core/xajax.inc.php');
        $this->xajax = new xajax();
        $this->xajax->configure('errorHandler', true);
        $this->xajax->configure('javascript URI', 'img');
        $this->xajax->register(XAJAX_FUNCTION, array('select_phone', $this, 'select_phone'));
        $this->xajax->register(XAJAX_FUNCTION, array('pool_first_free', $this, 'pool_first_free'));
        $this->xajax->register(XAJAX_FUNCTION, array('generate_license', $this, 'generate_license'));
        $this->xajax->processRequest();

        $SMARTY->assign('xajax', $this->xajax->getJavascript());
        return;
    }

    /**
     * Adds some validation before VoIP edit form is submitted
     * 
     * @param array $hook_data Hook data
     * @return array Hook data
     */
    public function voipAccountEditBeforeSubmit($hook_data)
    {
        switch ($hook_data['voipaccountedit']['registration_type']) {
            case 'country+area+local':
                $hook_data['voipaccountedit']['login'] = $hook_data['voipaccountedit']['countrycode'] . $hook_data['voipaccountedit']['areacode'] . $hook_data['voipaccountedit']['shortclid'];
                break;
            case 'area+local':
                $hook_data['voipaccountedit']['login'] = $hook_data['voipaccountedit']['areacode'] . $hook_data['voipaccountedit']['shortclid'];
                break;
            case 'local':
                $hook_data['voipaccountedit']['login'] = $hook_data['voipaccountedit']['shortclid'];
                break;
            default:
                $hook_data['voipaccountedit']['login'] = $hook_data['voipaccountedit']['areacode'] . $hook_data['voipaccountedit']['shortclid'];
                break;
        }

        if (!empty($hook_data['error']['login'])) {
            unset($hook_data['error']['login']);
        }

        $hook_data['voipaccountedit']['phone'] = $hook_data['voipaccountedit']['countrycode'] . $hook_data['voipaccountedit']['areacode'] . $hook_data['voipaccountedit']['shortclid'];

        if (!empty($hook_data['error']['phone'])) {
            unset($hook_data['error']['phone']);
        }

        if (!empty($hook_data['error']['passwd'])) {
            unset($hook_data['error']['passwd']);
        }
        
        if ($hook_data['voipaccountedit']['passwd'] == str_repeat('*', 8)) {
            $voip_account_manager = new LMSVoipAccountManager($this->db, $this->auth, $this->cache, $this->syslog);
            $old_voip_account_data = $voip_account_manager->getVoipAccount($hook_data['voipaccountedit']['id']);
            $hook_data['voipaccountedit']['passwd'] = $old_voip_account_data['passwd'];
        }

        if (!preg_match('/^[_a-z0-9-!@#$%^&*?]+$/i', $hook_data['voipaccountedit']['passwd'])) {
            $hook_data['error']['passwd'] = trans('Specified password contains forbidden characters!');
        }

        $is_prepaid = isset($hook_data['voipaccountedit']['is_prepaid']);

        $is_active = isset($hook_data['voipaccountedit']['active']);

        $is_ported = isset($hook_data['voipaccountedit']['ported']);

        if (!$is_active && !$is_ported) {
            if (!$is_active) {
                if (!empty($hook_data['voipaccountedit']['autoactivation_date'])) {
                    if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/i', $hook_data['voipaccountedit']['autoactivation_date'])) {
                        $hook_data['error']['autoactivation_date'] = trans('Specified date is invalid!');
                    }
                }
            }
        }

        if ($hook_data['voipaccountedit']['countrycode'] == '') {
            $hook_data['error']['phone'] = trans('Voip account phone number is required!');
        }
        if ($hook_data['voipaccountedit']['areacode'] == '') {
            $hook_data['error']['phone'] = trans('Voip account phone number is required!');
        }
        if ($hook_data['voipaccountedit']['shortclid'] == '') {
            $hook_data['error']['phone'] = trans('Voip account phone number is required!');
        }

        if (empty($hook_data['voipaccountedit']['ctmid'])) {
            $hook_data['error']['ctmid'] = trans('You must select CTM node!');
        }

        if (empty($hook_data['voipaccountedit']['phoneid'])) {
            $hook_data['error']['phoneid'] = trans('You must select phone profile!');
        }

        if (empty($hook_data['voipaccountedit']['line'])) {
            $hook_data['error']['line'] = trans('You must select phone line!');
        }

        if (empty($hook_data['voipaccountedit']['context'])) {
            $hook_data['error']['context'] = trans('Context group is required!');
        }

        if (empty($hook_data['voipaccountedit']['host'])) {
            $hook_data['error']['host'] = trans('Host IP address is required!');
        }

        if (empty($hook_data['voipaccountedit']['registration_type'])) {
            $hook_data['error']['registration_type'] = trans('You must select registration type!');
        }

        if (!empty($hook_data['voipaccountedit']['mac_address']) && !check_mac($hook_data['voipaccountedit']['mac_address'])) {
            $hook_data['error']['mac_address'] = trans('Incorrect MAC address!');
        }

        if (!isset($hook_data['voipaccountedit']['was_prepaid']) || $hook_data['voipaccountedit']['was_prepaid']) {
            if (!array_key_exists('prepaid_state', $hook_data['voipaccountedit'])) {
                $hook_data['error']['prepaid_state'] = trans('You must enter prepaid VOIP account state!');
            } else {
                $hook_data['voipaccountedit']['prepaid_state'] = str_replace(',', '.', $hook_data['voipaccountedit']['prepaid_state']);
                if (!is_numeric($hook_data['voipaccountedit']['prepaid_state'])) {
                    $hook_data['error']['prepaid_state'] = trans('Prepaid VOIP account state must be a numeric value!');
                }
            }
        } else {
            if (array_key_exists('absolute_cost_limit', $hook_data['voipaccountedit'])) {
                if (!empty($hook_data['voipaccountedit']['absolute_cost_limit']) && !is_numeric($hook_data['voipaccountedit']['absolute_cost_limit'])) {
                    $hook_data['error']['absolute_cost_limit'] = trans('Absolute monthly limit must be a numeric value!');
                }
            }
        }

        $hook_data['voipaccountedit']['access'] = true;
        
        $hook_data['voipaccountedit']['submit'] = true;
        
        return $hook_data;
    }

    /**
     * Adds some data to VoIP edit form template
     * 
     * @global Session $SESSION Session
     * @param array $hook_data Hook data
     * @return array Hook data
     */
    public function voipAccountEditBeforeDisplay(array $hook_data)
    {
        try {
            $voip_phone_and_login = LMSDB::getInstance()->getRow(
                'SELECT phone, login FROM voipaccounts WHERE id = ?',
                array($hook_data['voipaccountinfo']['id'])
            );
            $hook_data['voipaccountinfo']['phone'] = $voip_phone_and_login['phone'];
            $hook_data['voipaccountinfo']['login'] = $voip_phone_and_login['login'];

            $ctm_manager = new AdescomCTMManager();
            $phone_manager = new AdescomPhoneManager();
            $context_manager = new AdescomContextManager();
            $tariff_manager = new AdescomTariffManager();
            $pool_manager = new AdescomPoolManager();
            $clid_manager = new AdescomClidManager();
            $clid_services_manager = new AdescomClidServiceManager();
            $clid_limits_manager = new AdescomClidLimitManager();
            
            $ctms = $ctm_manager->getCTMNodes();
            $phones = $phone_manager->getPhones();
            $contexts = $context_manager->getContexts();
            $tariffs = $tariff_manager->getTariffs();
            $pools = $pool_manager->getAllPools();
            $blocklevels = $clid_services_manager->getBlockLevels();
            $voipdetails = $clid_manager->getCLID($hook_data['voipaccountinfo']['phone']);
            $voipservices = $clid_services_manager->getCLIDServices($hook_data['voipaccountinfo']['phone']);
            $allow_activation = !$voipdetails['active']  && !$voipdetails['ported'];
            
            $hook_data['smarty']->assign('was_prepaid', $voipdetails['is_prepaid']);
            
            if (empty($hook_data['voipaccountinfo']['submit'])) {
                $voipaccountinfo = array_merge($hook_data['voipaccountinfo'], $voipdetails, $voipservices);
            } else {
                $voipaccountinfo = array_merge($voipdetails, $voipservices, $hook_data['voipaccountinfo']);
            }

            if ($voipdetails['is_prepaid']) {
                $prepaid_state = $clid_limits_manager->getCLIDPrepaidAccountState($voipaccountinfo['phone']);

                if (isset($prepaid_state['value'])) {
                    $voipaccountinfo['prepaid_state'] = $prepaid_state['value'];
                } else {
                    $voipaccountinfo['prepaid_state'] = 0;
                }
            } else {
                $postpaid_limit = $clid_limits_manager->getCLIDPostpaidLimit($voipaccountinfo['phone'], $connection);

                if (isset($postpaid_limit['absolute_limit'])) {
                    $voipaccountinfo['absolute_cost_limit'] = $postpaid_limit['absolute_limit'];
                } else {
                    $voipaccountinfo['absolute_cost_limit'] = null;
                }
            }
            
            $selectedPhone = ArrayHelper::arrayGetValue($voipaccountinfo['phoneid'], $phones);
	
            if ($selectedPhone) {
		$hook_data['smarty']->assign('selectedPhone', $selectedPhone);
            }
            
        } catch (Exception $e) {
            error_log($e);
            die();
        }
        
        $hook_data['voipaccountinfo'] = $voipaccountinfo;

        $hook_data['smarty']->assign('ctms', $ctms);
        $hook_data['smarty']->assign('phones', $phones);
        $hook_data['smarty']->assign('contexts', $contexts);
        $hook_data['smarty']->assign('voip_tariffs', $tariffs);
        $hook_data['smarty']->assign('pools', $pools);
        $hook_data['smarty']->assign('blocklevels', $blocklevels);
        
        return $hook_data;
    }

}
