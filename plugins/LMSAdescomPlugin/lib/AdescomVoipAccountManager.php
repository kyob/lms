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
 * AdescomVoipAccountManager
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class AdescomVoipAccountManager extends LMSVoipAccountManager implements LMSVoipAccountManagerInterface
{

    public function getCustomerVoipAccounts($id)
    {
        $customervoipaccounts = parent::getCustomerVoipAccounts($id);

        try {
            
            $client_manager = new AdescomClientManager();
            $client = $client_manager->getClient($id);
            
            if ($client && $customervoipaccounts['accounts'] && !empty($customervoipaccounts['accounts'])) {
                foreach ($customervoipaccounts['accounts'] as $voipaccount) {
                    $clids[] = $voipaccount['phone'];
                }

                $clid_manager = new AdescomClidManager();
                $clid_limit_manager = new AdescomClidLimitManager();
                $tariff_manager = new AdescomTariffManager();

                $clids_status = $clid_manager->getCLIDsStatus($clids);
                $clids_account_state = $clid_limit_manager->getCLIDsAccountState($clids);
                $clids_details = $clid_manager->getCLIDsForClient($id);
                $clids_limits = $clid_limit_manager->getCLIDsPostpaidLimits($clids);
                $tariffs = $tariff_manager->getTariffs();
                $soap_clids = $clid_manager->getCLIDs($clids);
                
                $soap_clids_assoc = array();
                $clids_status_assoc = array();
                $clids_account_state_assoc = array();
                $clids_details_assoc = array();
                $clids_limits_assoc = array();
                
                foreach ($soap_clids as $soap_clid) {
                    $callerid = $soap_clid['callerid'];
                    $soap_clids_assoc[$callerid] = $soap_clid;
                }

                foreach ($clids_status as $clid_status) {
                    $clids_status_assoc[$clid_status['callerID']] = $clid_status;
                }

                foreach ($clids_account_state as $clid_account_state) {
                    $clids_account_state_assoc[$clid_account_state['callerID']] = $clid_account_state;
                }

                foreach ($clids_details as $clid_details) {
                    $clids_details_assoc[$clid_details['callerid']] = $clid_details;
                }

                foreach ($clids_limits as $clid_limit) {
                    $clids_limits_assoc[$clid_limit['callerID']] = $clid_limit;
                }


                foreach ($customervoipaccounts['accounts'] as &$voipaccount) {
                    $phone = $voipaccount['phone'];

                    $clid_status = isset($clids_status_assoc[$phone]) ? $clids_status_assoc[$phone] : null;
                    $clid_account_state = isset($clids_account_state_assoc[$phone]) ? $clids_account_state_assoc[$phone] : null;
                    $clid_details = isset($clids_details_assoc[$phone]) ? $clids_details_assoc[$phone] : null;
                    $clid_limit = isset($clids_limits_assoc[$phone]) ? $clids_limits_assoc[$phone] : null;

                    $voipaccount['status'] = $clid_status ? $clid_status : 0;

                    if ($clid_account_state && $clid_account_state['valid']) {
                        $voipaccount['account_state_type'] = $clid_account_state['isPrepaid'];
                        $voipaccount['account_state'] = $clid_account_state['value'];
                    } else {
                        $voipaccount['account_state'] = null;
                    }

                    if ($clid_details !== null) {
                        $voipaccount['is_prepaid'] = $clid_details['is_prepaid'];
                    }

                    if ($clid_limit !== null) {
                        $voipaccount['absolute_limit'] = $clid_limit['absoluteLimit'];
                    }
                    foreach ($tariffs as $t) {
                        if ($t['id'] === $soap_clids_assoc[$phone]['tariffid']) {
                            $voipaccount['tariff'] = $t;
                            break;
                        }
                    }
                }
            }
        } catch (Exception $e) {
            error_log($e);
            header('Location: ?m=adescomerror');
            die;
        }

        return $customervoipaccounts;
    }

    public function VoipAccountAdd($voipaccountdata)
    {
        $voipaccountid = null;

        try {
            $this->db->BeginTrans();

            $voipaccountdata['access'] = 1;
            $voipaccountid = parent::voipAccountAdd($voipaccountdata);

            if ($voipaccountid) {
                try {
                    $client_manager = new AdescomClientManager();
                    $clid_manager = new AdescomClidManager();
                    $clid_service_manager = new AdescomClidServiceManager();
                    $clid_limits_manager = new AdescomClidLimitManager();
                    $client = $client_manager->getClient($voipaccountdata['ownerid']);

                    if ($client === null) {
                        $customer_manager = new LMSCustomerManager($this->db, $this->auth, $this->cache, $this->syslog);
                        $customerinfo = $customer_manager->GetCustomer($voipaccountdata['ownerid']);
                        $customerinfo['tariffid'] = $voipaccountdata['tariffid'];
                        $client_manager->addClient($customerinfo);
                    } elseif ($client['deleted'] === true) {
                        $this->db->RollbackTrans();
                        error_log('Client is marked as deleted at CTM!');
                        header('Location: ?m=adescom_error');
                        die;
                    }

                    $clid_manager->addCLID($voipaccountdata['ownerid'], $voipaccountdata);

                    $clid_service_manager->saveCLIDServices($voipaccountdata['phone'], $voipaccountdata);

                    if (isset($voipaccountdata['is_prepaid'])) {
                        $clid_limits_manager->addCLIDPrepaidAccountState($voipaccountdata['phone'], array('expire_date' => null, 'value' => $voipaccountdata['prepaid_state']));
                    } elseif (array_key_exists('absolute_cost_limit', $voipaccountdata) && !empty($voipaccountdata['absolute_cost_limit'])) {
                        $clid_limits_manager->setCLIDPostpaidLimit($voipaccountdata['phone'], array('absolute_limit' => $voipaccountdata['absolute_cost_limit'], 'relative_limit' => null));
                    }
                } catch (Exception $e) {
                    error_log($e);
                    header('Location: ?m=adescom_error');
                    die;
                }
            }
            $this->db->CommitTrans();
        } catch (SoapFault $e) {
            switch ($e->detail->code) {
                case 'number_already_in_use':
                    $error['phone'] = trans('Specified phone is in use!');
                    break;
                case 'number_part_missing':
                    $error['phone'] = trans('Missing part of number!');
                    break;
                case 'inconsistent_number':
                    $error['phone'] = trans('Incosistent number value!');
                    break;
                case 'invalid_registration_type':
                    $error['registration_type'] = trans('Invalid value!');
                    break;
                case 'client_not_found':
                    $error['customer'] = trans('Invalid value!');
                    break;
                case 'unable_save_clid':
                    $error['phone'] = trans('Unable to save changes!');
                    break;
                case 'invalid_field_value':
                    break;
            }

            $this->db->RollbackTrans();

            error_log($e);
        }


        return $voipaccountid;
    }

    public function VoipAccountUpdate($voipaccountedit)
    {
        $result = null;
        
        try {
            $this->db->BeginTrans();

            $current_voipaccount_ownerid = parent::getVoipAccountOwner($voipaccountedit['id']);
            
            $result = parent::VoipAccountUpdate($voipaccountedit);

            try {
                $clid_manager = new AdescomClidManager();
                $clid_service_manager = new AdescomClidServiceManager();
                $clid_limits_manager = new AdescomClidLimitManager();

                if ($voipaccountedit['ownerid'] !== $current_voipaccount_ownerid) {
                    
                    $client_manager = new AdescomClientManager();
                    $client = $client_manager->getClient($voipaccountedit['ownerid']);
                    if ($client === null) {
                        $customer_manager = new LMSCustomerManager($this->db, $this->auth, $this->cache, $this->syslog);
                        $customerinfo = $customer_manager->GetCustomer($voipaccountedit['ownerid']);
                        $customerinfo['tariffid'] = $voipaccountedit['tariffid'];
                        $client_manager->addClient($customerinfo);
                    }
                    $current_clid = $clid_manager->getCLID($voipaccountedit['phone']);
                    $voipaccountedit['poolid'] = $current_clid['poolid'];
                    $voipaccountedit['ported'] = $current_clid['ported'];
                    $voipaccountedit['active'] = true;
                    $clid_manager->deleteCLID($voipaccountedit['phone']);
                    $clid_manager->addCLID($voipaccountedit['ownerid'], $voipaccountedit);
                } else {
                    $clid_manager->modifyCLID($voipaccountedit['phone'], $voipaccountedit);
                }

                $clid_service_manager->saveCLIDServices($voipaccountedit['phone'], $voipaccountedit);

                if (!$voipaccountedit['is_prepaid']) {
                    if (array_key_exists('absolute_cost_limit', $voipaccountedit) && !empty($voipaccountedit['absolute_cost_limit'])) {
                        $clid_limits_manager->setCLIDPostpaidLimit(
                                $voipaccountedit['phone'], array(
                            'absolute_limit' => $voipaccountedit['absolute_cost_limit'],
                            'relative_limit' => null
                                )
                        );
                    }
                }
            } catch (Exception $e) {
                $this->db->RollbackTrans();
                error_log($e);
                header('Location: ?m=adescom_error');
                die;
            }

            $this->db->CommitTrans();
        } catch (SoapFault $e) {
            switch ($e->detail->code) {
                case 'number_already_in_use':
                    $error['phone'] = trans('Specified phone is in use!');
                    break;
                case 'number_part_missing':
                    $error['phone'] = trans('Missing part of number!');
                    break;
                case 'inconsistent_number':
                    $error['phone'] = trans('Incosistent number value!');
                    break;
                case 'invalid_registration_type':
                    $error['registration_type'] = trans('Invalid value!');
                    break;
                case 'client_not_found':
                    $error['customer'] = trans('Invalid value!');
                    break;
                case 'unable_save_clid':
                    $error['phone'] = trans('Unable to save changes!');
                    break;
                case 'invalid_field_value':
                    break;
            }

            $this->db->RollbackTrans();

            error_log($e);
        }


        return $result;
    }

    public function deleteVoipAccount($id)
    {
        $result = null;

        try {
            $this->db->BeginTrans();
            $voip = $this->GetVoipAccount($id);
            $clid_manager = new AdescomClidManager();
            $clid_manager->deleteCLID($voip['phone']);
            $result = parent::deleteVoipAccount($id);
        } catch (Exception $ex) {
            $this->db->RollbackTrans();
            switch ($e->detail->code) {
                case 'unable_delete_clid':
                    $body = '<P>' . trans('Unable to delete CLID!') . '</P>';
                    break;
                default:
                    error_log($e);
                    header('Location: ?m=adescom_error');
                    die;
            }
        }

        return $result;
    }

}
