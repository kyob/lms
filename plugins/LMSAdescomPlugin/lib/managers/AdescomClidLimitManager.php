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
 * AdescomClidLimitManager
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class AdescomClidLimitManager
{
    /**
     * Returns CLIDs account states
     * 
     * @param array $clids CLIDs
     * @param AdescomSoapClient $connection Connection
     * @return array CLIDs account states
     */
    public function getCLIDsAccountState(array $clids, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $response = $connection->getCLIDsAccountState($clids);

        $results = array();

        if (is_array($response->items)) {
            foreach ($response->items as $clid_account_state) {
                $results[] = self::getCLIDAccountStateArray($clid_account_state);
            }
        }

        return $results;
    }

    /**
     * Returns CLIDs postpaid limits
     * 
     * @param array $clids CLIDs
     * @param AdescomSoapClient $connection Connection
     * @return array CLIDs postpaid limits
     * @throws SoapFault if CLID not found
     */
    public function getCLIDsPostpaidLimits(array $clids, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }
        
        $results = array();

        try {
            $response = $connection->getCLIDsPostpaidLimits((object) array('items' => $clids));
        } catch (SoapFault $e) {
            if ($e->detail->code == 'clids_not_found') {
                return $results;
            }
            throw $e;
        }

        if (is_array($response->items)) {
            foreach ($response->items as $postpaid_limit) {
                $results[] = self::getCLIDPostpaidLimitArray($postpaid_limit);
            }
        }

        return $results;
    }

    /**
     * Returns CLID account state
     * 
     * @param string $clid CLID
     * @param AdescomSoapClient $connection Connection
     * @return array CLID account state 
     */
    public function getCLIDAccountState($clid, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $response = $connection->getCLIDsAccountState(array($clid));

        if (is_array($response->items)) {
            foreach ($response->items as $clid_account_state) {
                return self::getCLIDAccountStateArray($clid_account_state);
            }
        }

        return null;
    }

    /**
     * Returns CLID prepaid state
     * 
     * @param string $callerID CLID
     * @param AdescomSoapClient $connection Connection
     * @return array CLID prepaid state
     * @throws Exception if webservice type is unknown
     */
    public function getCLIDPrepaidAccountState($callerID, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $state = null;
        $webservices_type = ConfigHelper::getConfig('adescom.webservices_type');
        switch ($webservices_type) {
            case AdescomConnection::PLATFORM_WEBSERVICE:
                $state = $connection->getPrepaidBalance($callerID);
                break;
            case AdescomConnection::FRONTEND_WEBSERVICE:
                $state = $connection->getCLIDPrepaidAccountState($callerID)->value;
                break;
            default:
                throw new Exception('Unknown webservice type!'); 
        }
        
        $result = array();
        $result['caller_id'] = $callerID;
        $result['expire_date'] = null;
        $result['value'] = $state;
        return $result;
    }

    /**
     * Sets CLID prepaid state
     * 
     * @param string $callerID CLID
     * @param array $state Prepaid state
     * @param AdescomSoapClient $connection Connection
     */
    public function setCLIDPrepaidAccountState($callerID, array $state, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $data = new stdClass();
        $data->expireDate = $state['expire_date'];
        $data->value = $state['value'];

        $connection->setCLIDPrepaidAccountState($callerID, $data);
    }

    /**
     * Adds value to prepaid account state
     * 
     * @param string $callerID CLID
     * @param array $state Prepaid state
     * @param AdescomSoapClient $connection Connection
     * @throws Exception if webservice type is unknown
     */
    public function addCLIDPrepaidAccountState($callerID, array $state, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $data = new stdClass();
        $data->expireDate = $state['expire_date'];
        $data->value = $state['value'];
        
        $webservices_type = ConfigHelper::getConfig('adescom.webservices_type');
        switch ($webservices_type) {
            case AdescomConnection::PLATFORM_WEBSERVICE:
                $connection->addPrepaidAmount($callerID, $state['value']);
                break;
            case AdescomConnection::FRONTEND_WEBSERVICE:
                $connection->addCLIDPrepaidAccountState($callerID, $data);
                break;
            default:
                throw new Exception('Unknown webservice type!'); 
        }
    }

    /**
     * Returns CLID postpaid limit
     * 
     * @param string $callerID CLID
     * @param AdescomSoapClient $connection Connection
     * @return array Postpaid limit
     */
    public function getCLIDPostpaidLimit($callerID, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $limit = $connection->getCLIDPostpaidLimits($callerID);

        $result = array();
        $result['caller_id'] = $callerID;
        $result['absolute_limit'] = $limit->absoluteLimit === null ? -1 : (double) $limit->absoluteLimit;
        $result['relative_limit'] = $limit->relativeLimit;
        return $result;
    }

    /**
     * Sets CLID postpaid limit
     * 
     * @param string $callerID CLID
     * @param array $limit Postpaid limit
     * @param AdescomSoapClient $connection
     */
    public function setCLIDPostpaidLimit($callerID, array $limit, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $data = new stdClass();
        $data->absoluteLimit = $limit['absolute_limit'];
        $data->relativeLimit = $limit['relative_limit'];

        $connection->setCLIDPostpaidLimits($callerID, $data);
    }

    /**
     * Returns default postpaid limit
     * 
     * @param AdescomSoapClient $connection Connection
     * @return array Default postpaid limit
     */
    public function getDefaultPostpaidLimits(AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $limit = $connection->getDefaultPostpaidLimits();

        $result = array();
        $result['caller_id'] = $callerID;
        $result['absolute_limit'] = $limit->absoluteLimit;
        $result['relative_limit'] = $limit->relativeLimit;

        return $result;
    }

    /**
     * Sets default postpaid limit
     * 
     * @param array $limit Postpaid limit
     * @param AdescomSoapClient $connection Connection
     */
    public function setDefaultPostpaidLimits(array $limit, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $data = new stdClass();
        $data->absoluteLimit = $limit['absolute_limit'];
        $data->relativeLimit = $limit['relative_limit'];

        $connection->setDefaultPostpaidLimits($data);
    }
    
    /**
     * Returns CLID account state as array
     * 
     * @param stdClass $state State as object
     * @return array State as array
     */
    static private function getCLIDAccountStateArray(stdClass $state)
    {
        $item = array();
        $item['callerID'] = $state->callerID;
        $item['valid'] = $state->valid;

        if ($state->valid) {
            $item['isPrepaid'] = $state->isPrepaid;
            if ($state->isPrepaid) {
                $item['value'] = $state->prepaidState->value;
            } else {
                $item['value'] = $state->postpaidState->value;
            }
        }

        return $item;
    }

    /**
     * Returns CLID postpaid limit as array
     * 
     * @param stdClass $limit Limit as object
     * @return array Limit as array
     */
    static private function getCLIDPostpaidLimitArray(stdClass $limit)
    {
        $item = array();
        $item['callerID'] = $limit->callerID;
        $item['absoluteLimit'] = $limit->absoluteLimit === null ? -1 : (double) $limit->absoluteLimit;
        $item['relativeLimit'] = $limit->relativeLimit;
        return $item;
    }

}
