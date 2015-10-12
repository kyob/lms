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
 * AdescomClientManager
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class AdescomClientManager
{
    /**
     * Adds client
     * 
     * @param array $client Client
     * @param AdescomSoapClient $connection Connection
     * @return stdClass Client
     * @throws Exception if webservice is unknown
     */
    public function addClient(array $client, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }
        $details = null;
        $reseller_id = ConfigHelper::getConfig('adescom.reseller_id');
        $webservices_type = ConfigHelper::getConfig('adescom.webservices_type');
        switch ($webservices_type) {
            case AdescomConnection::PLATFORM_WEBSERVICE:
                $details = self::prepareClientData($client, $reseller_id);
                break;
            case AdescomConnection::FRONTEND_WEBSERVICE:
                $details = self::prepareClientDataFrontend($client, $reseller_id);
                break;
            default:
                throw new Exception('Unknown webservice type!');                
        }
        return $connection->addClient($details);
    }

    /**
     * Returns client
     * 
     * @param int $id Client id
     * @param AdescomSoapClient $connection Connection
     * @return array Client
     */
    public function getClient($id, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }
        try {
            $client = $connection->getClientByExternalID($id);
        } catch (Exception $e) {
            return null;
        }
        return self::getClientArray($client);
    }
    
    /**
     * Returns clients
     * 
     * @param AdescomSoapClient $connection Connection
     * @return array Clients
     */
    public function getClients(AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $response = $connection->getClients();

        $results = array();

        if (is_array($response->items)) {
            foreach ($response->items as $client) {
                $results[] = self::getClientArray($client);
            }
        }

        return $results;
    }
    
    /**
     * Returns clients
     * 
     * @param array $clients Clients
     * @param AdescomSoapClient $connection Connection
     * @return stdClass Response
     * @throws Exception if webservice is unknown
     */
    public function addClients(array $clients, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $request = new stdClass();

        $webservices_type = ConfigHelper::getConfig('adescom.webservices_type');
        switch ($webservices_type) {
            case AdescomConnection::PLATFORM_WEBSERVICE:
                $request->clients = array();
                foreach ($clients as $client) {
                    $details = self::prepareClientData($client);
                    $request->clients[] = $details;
                }
                $request->count = count($request->clients);
                break;
            case AdescomConnection::FRONTEND_WEBSERVICE:
                $request->items = array();
                foreach ($clients as $client) {
                    $details = self::prepareClientDataFrontend($client);
                    $request->items[] = $details;
                }
                $request->count = count($request->items);
                break;
            default:
                throw new Exception('Unknown webservice type!'); 
        }

        // add new clients
        return $connection->addClients($request);
    }
    
    /**
     * Modifies client
     * 
     * @param array $client Client
     * @param AdescomSoapClient $connection Connection
     * @return type Response
     * @throws Exception if webservice is unknown
     */
    public function modifyClient(array $client, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $details = null;
        $webservices_type = ConfigHelper::getConfig('adescom.webservices_type');
        switch ($webservices_type) {
            case AdescomConnection::PLATFORM_WEBSERVICE:
                $details = self::prepareClientData($client);
                break;
            case AdescomConnection::FRONTEND_WEBSERVICE:
                $details = self::prepareClientDataFrontend($client);
                break;
            default:
                throw new Exception('Unknown webservice type!');                
        }
        
        return $connection->modifyClientByExternalID($client['id'], $details);
    }
    
    /**
     * Modifies clients
     * 
     * @param array $clients Clients
     * @param AdescomSoapClient $connection Connection
     * @return stdClass Response
     * @throws Exception if service is unknown
     */
    public function modifyClients(array $clients, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $request = new stdClass();
        $request->clients = array();
        
        $webservices_type = ConfigHelper::getConfig('adescom.webservices_type');
        switch ($webservices_type) {
            case AdescomConnection::PLATFORM_WEBSERVICE:
                foreach ($clients as $client) {
                    $details = self::prepareClientData($client);
                    $request->clients[] = $details;
                }
                break;
            case AdescomConnection::FRONTEND_WEBSERVICE:
                foreach ($clients as $client) {
                    $details = self::prepareClientDataFrontend($client);
                    $request->clients[] = $details;
                }
                break;
            default:
                throw new Exception('Unknown webservice type!'); 
        }

        $request->count = count($request->clients);

        return $connection->modifyClients($request);
    }
    
    /**
     * Deletes client
     * 
     * @param int $id Client id
     * @param AdescomSoapClient $connection Connection
     */
    public function deleteClient($id, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }
        $connection->deleteClientByExternalID($id);
    }
    
    /**
     * Returns client details object for frontend webservices
     * 
     * @param array $client Client
     * @param int $resellerId Reseller id
     * @return \stdClass Client details
     */
    static private function prepareClientDataFrontend(array $client, $resellerId = null)
    {
        $details = new stdClass();
        $details->clientID = null;
        $details->resellerID = $resellerId;

        if (array_key_exists('clientid', $client)) {
            $details->clientID = $client['clientid'];
        }

        if (array_key_exists('name', $client)) {
            $details->firstName = $client['name'];
        }

        if (array_key_exists('lastname', $client)) {
            $details->name = $client['lastname'];
        }

        if (array_key_exists('address', $client)) {
            $details->street = $client['address'];
        }

        if (array_key_exists('house', $client)) {
            $details->house = $client['house'];
        }

        if (array_key_exists('apartment', $client)) {
            $details->apartment = $client['apartment'];
        }

        if (array_key_exists('zip', $client)) {
            $details->zip = $client['zip'];
        }

        if (array_key_exists('city', $client)) {
            $details->city = $client['city'];
        }

        if (array_key_exists('state', $client)) {
            $details->state = $client['state'];
        }

        if (array_key_exists('country', $client)) {
            $details->country = $client['country'];
        }

        if (array_key_exists('email', $client)) {
            $details->email = $client['email'];
        }

        if (array_key_exists('contacts', $client)) {
            $details->phone1 = isset($client['contacts'][0]) ? $client['contacts'][0]['phone'] : null;
        }

        if (array_key_exists('ten', $client)) {
            $details->nip = $client['ten'];
        }

        if (array_key_exists('tariffid', $client)) {
            $details->tariffID = $client['tariffid'];
        }

        if (array_key_exists('id', $client)) {
            $details->externalID = $client['id'];
        }

        return $details;
    }

    /**
     * Returns client details object for platform webservices
     * 
     * @param array $client Client
     * @param type $resellerId Reseller id
     * @return \stdClass Client details
     */
    static private function prepareClientData(array $client, $resellerId = null)
    {
        $details = new stdClass();
        $details->clientID = null;
        $details->resellerID = $resellerId;
        $details->contactDetails = new stdClass();
        $details->billingDetails = new stdClass();

        if (array_key_exists('clientid', $client)) {
            $details->clientID = $client['clientid'];
        }

        if (array_key_exists('name', $client)) {
            $details->contactDetails->firstname = $client['name'];
            $details->billingDetails->firstname = $client['name'];
        }

        if (array_key_exists('lastname', $client)) {
            $details->contactDetails->name = $client['lastname'];
            $details->billingDetails->name = $client['lastname'];
        }

        if (array_key_exists('address', $client)) {
            $details->contactDetails->street = $client['address'];
            $details->billingDetails->street = $client['address'];
        }

        if (array_key_exists('house', $client)) {
            $details->contactDetails->house = $client['house'];
            $details->billingDetails->house = $client['house'];
        }

        if (array_key_exists('apartment', $client)) {
            $details->contactDetails->apartment = $client['apartment'];
            $details->billingDetails->apartment = $client['apartment'];
        }

        if (array_key_exists('zip', $client)) {
            $details->contactDetails->zip = $client['zip'];
            $details->billingDetails->zip = $client['zip'];
        }

        if (array_key_exists('city', $client)) {
            $details->contactDetails->city = $client['city'];
            $details->billingDetails->city = $client['city'];
        }

        if (array_key_exists('state', $client)) {
            $details->contactDetails->state = $client['state'];
            $details->billingDetails->state = $client['state'];
        }

        if (array_key_exists('country', $client)) {
            $details->contactDetails->country = $client['country'];
            $details->billingDetails->country = $client['country'];
        }

        if (array_key_exists('email', $client)) {
            $details->contactDetails->email = $client['email'];
        }

        if (array_key_exists('contacts', $client)) {
            $details->contactDetails->phone1 = isset($client['contacts'][0]) ? $client['contacts'][0]['phone'] : null;
        }

        if (array_key_exists('ten', $client)) {
            $details->billingDetails->nip = $client['ten'];
        }

        if (array_key_exists('tariffid', $client)) {
            $details->billingDetails->tariffID = $client['tariffid'];
        }

        if (array_key_exists('id', $client)) {
            $details->externalID = $client['id'];
        }
        
        return $details;
    }

    /**
     * Converts client object to array
     * 
     * @param stdClass $client Client
     * @return array Client
     */
    static private function getClientArray(stdClass $client = null)
    {
        if ($client === null) {
            return null;
        }

        $result = array();
        $result['id'] = $client->externalID;
        $result['clientid'] = $client->clientID;
        $result['tariffid'] = $client->billingDetails->tariffID;
        $result['name'] = $client->billingDetails->firstName;
        $result['lastname'] = $client->billingDetails->name;
        $result['street'] = $client->billingDetails->street;
        $result['house'] = $client->billingDetails->house;
        $result['apartment'] = $client->billingDetails->apartment;
        $result['zip'] = $client->billingDetails->zip;
        $result['city'] = $client->billingDetails->city;
        $result['state'] = $client->billingDetails->state;
        $result['country'] = $client->billingDetails->country;
        $result['email'] = $client->contactDetails->email;
        $result['customername'] = $client->firstname . ' ' . $client->name;
        $result['address'] = $client->billingDetails->street . ' ' . $client->billingDetails->house . '/' . $client->billingDetails->apartment;
        $result['deleted'] = $client->deleted;

        return $result;
    }

    
}
