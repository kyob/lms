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
 * VoipAccountHandlerAbstract
 *
 * @package 
 * @author Maciej Lew <maciej.lew@adescom.pl>
 */
abstract class VoipAccountHandlerAbstract
{
    /**
     * Triggers after phone is selected. Returns additional options.
     * 
     * @global Smarty $SMARTY Smarty
     * @param int $phoneid Phone id
     * @param string $phone_line_templates Template name
     * @return \xajaxResponse Response
     */
    public function select_phone($phoneid, $phone_line_templates = null)
    {
        global $SMARTY;
        $phone_manager = new AdescomPhoneManager();
        $phone = $phone_manager->getPhone($phoneid);
        $SMARTY->assign('phone', $phone);
        $output = $SMARTY->fetch($phone_line_templates);
        $response = new xajaxResponse();
        $response->assign('voipaccountdata_line_parent', 'innerHTML', $output);
        return $response;
    }
    
    /**
     * Triggers after first free request is selected
     * 
     * @param int $poolid Pool id
     * @return \xajaxResponse Response
     */
    public function pool_first_free($poolid)
    {
        $pool_manager = new AdescomPoolManager();
        $number = $pool_manager->getPoolFirstFree($poolid);
        $response = new xajaxResponse();
        if ($number !== null) {
            $response->assign('voipaccountdata_countrycode', 'value', $number[0]);
            $response->assign('voipaccountdata_areacode', 'value', $number[1]);
            $response->assign('voipaccountdata_shortclid', 'value', $number[2]);
        }
        return $response;
    }
    
    /**
     * Triggers after generate license request is selected
     * 
     * @return \xajaxResponse Response
     */
    public function generate_license()
    {
        $clid_manager = new AdescomClidManager();
        $license = $clid_manager->generateCLIDLicense();
        $response = new xajaxResponse();
        $response->assign('voipaccountdata_password', 'value', $license);
        return $response;
    }
    
}
