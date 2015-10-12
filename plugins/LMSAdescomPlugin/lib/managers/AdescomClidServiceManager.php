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
 * AdescomClidServiceManager
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class AdescomClidServiceManager
{
    /**
     * Returns CLID services
     * 
     * @param string $callerID CLID
     * @param AdescomSoapClient $connection Connection
     * @return array CLID services
     */
    public function getCLIDServices($callerID, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $filter = array("clip_enabled", "clir_allowed", "clir_enabled", "acrej_allowed", "acrej_enabled", "clirovr_enabled", "dnd_enabled", "dnd_allowed", "hotline_allowed", "hotline_extension", "cw_enabled", "cw_allowed", "nway_allowed", "alarmcall_allowed", "forwarding_enabled", "cfu", "cfb", "cfnr", "cfur", "enf2m_enabled", "f2m_xferallowed", "uf2m_enabled", "nrf2m_enabled", "atxfer_allowed", "blindxfer_allowed", "ocb_allowed", "ocb_level", "ocb_password");

        $services = $connection->getCLIDServices($callerID, $filter);

        foreach ($services->list as $service) {
            $services_assoc[$service->name] = $service->value;
        }

        $array = array();
        $array['clip'] = $services_assoc['clip_enabled'];
        $array['clir'] = $services_assoc['clir_enabled'];
        $array['clir_allowed'] = $services_assoc['clir_allowed'];
        $array['acrej'] = $services_assoc['acrej_enabled'];
        $array['acrej_allowed'] = $services_assoc['acrej_allowed'];
        $array['clirovr'] = $services_assoc['clirovr_enabled'];
        $array['dnd'] = $services_assoc['dnd_enabled'];
        $array['dnd_allowed'] = $services_assoc['dnd_allowed'];
        $array['hotline'] = $services_assoc['hotline_extension'];
        $array['hotline_allowed'] = $services_assoc['hotline_allowed'];
        $array['cw'] = $services_assoc['cw_enabled'];
        $array['cw_allowed'] = $services_assoc['cw_allowed'];
        $array['nway'] = $services_assoc['nway_allowed'];
        $array['alarm'] = $services_assoc['alarmcall_allowed'];
        $array['forwarding'] = $services_assoc['forwarding_enabled'];
        $array['cfu'] = $services_assoc['cfu'];
        $array['cfb'] = $services_assoc['cfb'];
        $array['cfnr'] = $services_assoc['cfnr'];
        $array['cfur'] = $services_assoc['cfur'];
        $array['f2m'] = $services_assoc['enf2m_enabled'];
        $array['f2m_xfer'] = $services_assoc['f2m_xferallowed'];
        $array['uf2m'] = $services_assoc['uf2m_enabled'];
        $array['nrf2m'] = $services_assoc['nrf2m_enabled'];
        $array['blind_xfer'] = $services_assoc['blindxfer_allowed'];
        $array['at_xfer'] = $services_assoc['atxfer_allowed'];
        $array['ocb_allowed'] = $services_assoc['ocb_allowed'];
        $array['ocb'] = $services_assoc['ocb_level'];
        $array['ocb_password'] = $services_assoc['ocb_password'];

        return $array;
    }
    
    
    /**
     * Saves CLID services
     * 
     * @param string $callerID CLID
     * @param array $services Services
     * @param AdescomSoapClient $connection Connection
     * @throws Exception if webservice is unknown
     */
    public function saveCLIDServices($callerID, array $services, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $values = new stdClass();
        $values->list = array();
        $values->list[] = array('name' => 'clip_enabled', 'value' => ArrayHelper::arrayGetBool('clip', $services, false));
        $values->list[] = array('name' => 'clir_enabled', 'value' => ArrayHelper::arrayGetBool('clir', $services, false));
        $values->list[] = array('name' => 'clir_allowed', 'value' => ArrayHelper::arrayGetBool('clir_allowed', $services, false));
        $values->list[] = array('name' => 'acrej_enabled', 'value' => ArrayHelper::arrayGetBool('acrej', $services, false));
        $values->list[] = array('name' => 'acrej_allowed', 'value' => ArrayHelper::arrayGetBool('acrej_allowed', $services, false));
        $values->list[] = array('name' => 'clirovr_enabled', 'value' => ArrayHelper::arrayGetBool('clirovr', $services, false));
        $values->list[] = array('name' => 'dnd_enabled', 'value' => ArrayHelper::arrayGetBool('dnd', $services, false));
        $values->list[] = array('name' => 'dnd_allowed', 'value' => ArrayHelper::arrayGetBool('dnd_allowed', $services, false));
        $values->list[] = array('name' => 'hotline_extension', 'value' => ArrayHelper::arrayGetString('hotline', $services, false));
        $values->list[] = array('name' => 'hotline_allowed', 'value' => ArrayHelper::arrayGetBool('hotline_allowed', $services, false));
        $values->list[] = array('name' => 'cw_enabled', 'value' => ArrayHelper::arrayGetBool('cw', $services, false));
        $values->list[] = array('name' => 'cw_allowed', 'value' => ArrayHelper::arrayGetBool('cw_allowed', $services, false));
        $values->list[] = array('name' => 'nway_allowed', 'value' => ArrayHelper::arrayGetBool('nway', $services, false));
        $values->list[] = array('name' => 'alarmcall_allowed', 'value' => ArrayHelper::arrayGetBool('alarm', $services, false));
        $values->list[] = array('name' => 'forwarding_enabled', 'value' => ArrayHelper::arrayGetBool('forwarding', $services, false));
        $values->list[] = array('name' => 'cfu', 'value' => ArrayHelper::arrayGetString('cfu', $services, ''));
        $values->list[] = array('name' => 'cfb', 'value' => ArrayHelper::arrayGetString('cfb', $services, ''));
        $values->list[] = array('name' => 'cfnr', 'value' => ArrayHelper::arrayGetString('cfnr', $services, ''));
        $values->list[] = array('name' => 'cfur', 'value' => ArrayHelper::arrayGetString('cfur', $services, ''));
        $values->list[] = array('name' => 'enf2m_enabled', 'value' => ArrayHelper::arrayGetBool('f2m', $services, false));
        $values->list[] = array('name' => 'f2m_xferallowed', 'value' => ArrayHelper::arrayGetBool('f2m_xfer', $services, false));
        $values->list[] = array('name' => 'uf2m_enabled', 'value' => ArrayHelper::arrayGetBool('uf2m', $services, false));
        $values->list[] = array('name' => 'nrf2m_enabled', 'value' => ArrayHelper::arrayGetBool('nrf2m', $services, false));
        $values->list[] = array('name' => 'blindxfer_allowed', 'value' => ArrayHelper::arrayGetBool('blind_xfer', $services, false));
        $values->list[] = array('name' => 'atxfer_allowed', 'value' => ArrayHelper::arrayGetBool('at_xfer', $services, false));
        $values->list[] = array('name' => 'ocb_allowed', 'value' => ArrayHelper::arrayGetBool('ocb_allowed', $services, false));
        $values->list[] = array('name' => 'ocb_level', 'value' => ArrayHelper::arrayGetString('ocb', $services, false));
        $values->list[] = array('name' => 'ocb_password', 'value' => ArrayHelper::arrayGetString('ocb_password', $services, false));

        $webservices_type = ConfigHelper::getConfig('adescom.webservices_type');
        switch ($webservices_type) {
            case AdescomConnection::PLATFORM_WEBSERVICE:
                $connection->modifyCLIDServices($callerID, $values);
                break;
            case AdescomConnection::FRONTEND_WEBSERVICE:
                $connection->setCLIDServices($callerID, $values);
                break;
            default:
                throw new Exception('Unknown webservice type!'); 
        }
        
    }
    
    
    /**
     * Returns block levels
     * 
     * @param AdescomSoapClient $connection Connection
     * @return array Block levels
     */
    public function getBlockLevels(AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $result = $connection->getBlockLevels();
        
        $levels = array();

        if (is_array($result->items)) {
            foreach ($result->items as $item) {
                $levels[] = self::getBlockLevelArray($item);
            }
        }

        return $levels;
    }

    /**
     * Converts block level object to array
     * 
     * @param stdClass $level Block level
     * @return array Block level
     */
    private static function getBlockLevelArray(stdClass $level)
    {
        $item = array();
        $item['id'] = $level->id;
        $item['level'] = $level->level;
        $item['friendlyName'] = $level->friendlyName;
        $item['allowIncoming'] = $level->allowIncoming;
        $item['allowEmergency'] = $level->allowEmergency;
        return $item;
    }
}
