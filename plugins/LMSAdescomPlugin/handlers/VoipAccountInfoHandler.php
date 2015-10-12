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
 * VoipAccountInfoHandler
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class VoipAccountInfoHandler
{

    /**
     * Adds some data to VoIP account info template
     * 
     * @param array $hook_data Hook data
     * @return array Hook data
     */
    public function voipAccountInfoBeforeDisplay(array $hook_data)
    {
        try {
            $tariff_manager = new AdescomTariffManager();
            $clid_manager = new AdescomClidManager();
            $clid_limits_manager = new AdescomClidLimitManager();

            $caller_id = $hook_data['voipaccountinfo']['phone'];
            $voipdetails = $clid_manager->getCLID($caller_id);
            $state = $clid_limits_manager->getCLIDAccountState($caller_id);
            $status = $clid_manager->getCLIDStatus($caller_id);
            $postpaid_limits = $clid_limits_manager->getCLIDsPostpaidLimits(array($caller_id));
            $tariffs = $tariff_manager->getTariffs();
            foreach ($tariffs as $t) {
                if ($t['id'] === $voipdetails['tariffid']) {
                    $voipdetails['tariff'] = $t;
                    break;
                }
            }

            if ($state && $state['valid']) {
                $hook_data['voipaccountinfo']['account_state_type'] = $state['isPrepaid'];
                $hook_data['voipaccountinfo']['account_state'] = $state['value'];
            } else {
                $hook_data['voipaccountinfo']['account_state'] = null;
            }

            if (count($postpaid_limits)) {
                $postpaid_limit = end($postpaid_limits);
                $hook_data['voipaccountinfo']['absolute_limit'] = $postpaid_limit['absoluteLimit'];
            }

            if ($status !== null && isset($status->ipAddress) && isset($status->port)) {
                $hook_data['voipaccountinfo']['status'] = $status->status;
                $hook_data['voipaccountinfo']['ip_address'] = $status->ipAddress;
                $hook_data['voipaccountinfo']['port'] = $status->port;
            }

            
            $hook_data['voipaccountinfo'] = array_merge($hook_data['voipaccountinfo'], $voipdetails);
            
        } catch (Exception $e) {
            error_log($e);
            die();
        }


        return $hook_data;
    }

}
