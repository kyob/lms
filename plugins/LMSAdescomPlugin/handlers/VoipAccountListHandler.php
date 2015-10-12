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
 * VoipAccountListHandler
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class VoipAccountListHandler
{

    /**
     * Adds some data to VoIP accounts list template
     * 
     * @param array $hook_data Hook data
     * @return array Hook data
     */
    public function voipAccountListBeforeDisplay(array $hook_data)
    {
        global $SESSION;

        if (!isset($_GET['i'])) {
            if (isset($_GET['s'])) {
                $i = 0;
            } else {
                $SESSION->restore('nli', $i);
            }
        } else {
            $i = 1;
        }
        $SESSION->save('nli', $i);

        if (!isset($_GET['p'])) {
            if (isset($_GET['s'])) {
                $p = 0;
            } else {
                $SESSION->restore('nlp', $p);
            }
        } else {
            $p = 1;
        }
        $SESSION->save('nlp', $p);

        $hook_data['listdata']['only_inactive'] = $i;
        $hook_data['listdata']['only_ported'] = $p;

        try {
            if (!empty($hook_data['voipaccountlist'])) {
                foreach ($hook_data['voipaccountlist'] as $id => $voipaccount) {
                    if (!is_int($id)) {
                        continue;
                    }
                    $clids[] = $voipaccount['phone'];
                }

                $clid_manager = new AdescomClidManager();
                $clid_limit_manager = new AdescomClidLimitManager();
                $tariff_manager = new AdescomTariffManager();
                
                $clids_status = $clid_manager->getCLIDsStatus($clids);
                $clids_account_state = $clid_limit_manager->getCLIDsAccountState($clids);
                $clids_postpaid_limits = $clid_limit_manager->getCLIDsPostpaidLimits($clids);
                $soap_clids = $clid_manager->getCLIDs($clids);
                $tariffs = $tariff_manager->getTariffs();

                $clid_ported = array();
                $clid_active = array();

                foreach ($soap_clids as $soap_clid) {
                    $callerid = $soap_clid['callerid'];

                    if ($soap_clid['ported'] == true) {
                        $clid_ported[] = $callerid;
                    }

                    if ($soap_clid['active'] == true) {
                        $clid_active[] = $callerid;
                    }
                    
                    $soap_clids_assoc[$callerid] = $soap_clid;
                }

                foreach ($clids_status as $clid_status) {
                    $callerid = $clid_status['callerID'];
                    $clids_status_assoc[$callerid] = $clid_status;
                }

                foreach ($clids_account_state as $clid_account_state) {
                    $callerid = $clid_account_state['callerID'];
                    $clids_account_state_assoc[$callerid] = $clid_account_state;
                }

                foreach ($clids_postpaid_limits as $clid_postpaid_limits) {
                    $callerid = $clid_postpaid_limits['callerID'];
                    $clids_postpaid_limits_assoc[$callerid] = $clid_postpaid_limits;
                }

                foreach ($hook_data['voipaccountlist'] as $id => & $voipaccount) {
                    if (!is_int($id)) {
                        continue;
                    }

                    $phone = $voipaccount['phone'];

                    if ($hook_data['listdata']['only_inactive']) {
                        if (in_array($phone, $clid_active)) {
                            unset($hook_data['voipaccountlist'][$id]);
                            if (array_key_exists('total', $hook_data['voipaccountlist'])) {
                                $hook_data['voipaccountlist']['total']--;
                            }
                            continue;
                        }
                    }

                    if ($hook_data['listdata']['only_ported']) {
                        if (!in_array($phone, $clid_ported)) {
                            unset($hook_data['voipaccountlist'][$id]);
                            if (array_key_exists('total', $hook_data['voipaccountlist'])) {
                                $hook_data['voipaccountlist']['total']--;
                            }
                            continue;
                        }
                    }

                    $clid_status = isset($clids_status_assoc[$phone]) ? $clids_status_assoc[$phone] : null;
                    $clid_account_state = isset($clids_account_state_assoc[$phone]) ? $clids_account_state_assoc[$phone] : null;
                    $clid_postpaid_limits = isset($clids_postpaid_limits_assoc[$phone]) ? $clids_postpaid_limits_assoc[$phone] : null;

                    $voipaccount['status'] = $clid_status ? $clid_status['status'] : 0;
                    $voipaccount['ip_address'] = $clid_status ? $clid_status['ip_address'] : null;
                    $voipaccount['port'] = $clid_status ? $clid_status['port'] : null;

                    if ($clid_account_state && $clid_account_state['valid']) {
                        $voipaccount['account_state_type'] = $clid_account_state['isPrepaid'];
                        $voipaccount['account_state'] = $clid_account_state['value'];
                    } else {
                        $voipaccount['account_state'] = null;
                    }

                    if ($clid_postpaid_limits) {
                        $voipaccount['absolute_limit'] = $clid_postpaid_limits['absoluteLimit'];
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
            $SESSION->redirect('?m=adescom_error');
        }

        return $hook_data;
    }

}
