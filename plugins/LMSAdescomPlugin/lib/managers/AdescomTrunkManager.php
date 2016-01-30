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
 * AdescomTrunkManager
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class AdescomTrunkManager
{
    /**
     * Returns client trunks
     * 
     * @param int $clientID Client id
     * @param AdescomSoapClient $connection Connection
     * @return array Trunks
     */
    public function getTrunksForClient($clientID, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $response = $connection->getTrunkgroupsForClientByExternalID($clientID);

        $results = array();

        if (is_array($response->items)) {
            foreach ($response->items as $trunk) {
                $results[] = self::getTrunkArray($trunk);
            }
        }

        return $results;
    }
    
    /**
     * Returns trunks
     * 
     * @param int $total Total
     * @param AdescomSoapClient $connection Connection
     * @return array Trunks
     */
    public function getTrunks(&$total, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $response = $connection->getTrunkgroups();

        if ($response === null) {
            return null;
        }

        $total = $response->count;

        $results = array();

        if (is_array($response->items)) {
            foreach ($response->items as $item) {
                $results[] = self::getTrunkArray($item);
            }
        }

        return $results;
    }
    
    /**
     * Returns channels
     * 
     * @param int $ctmid CTM id
     * @param AdescomSoapClient $connection Connection
     * @return array Channels
     */
    public function getChannels($ctmid, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        try {
            $response = $connection->getChannels($ctmid);
        } catch (Exception $e) {
            return null;
        }

        $results = array();

        if (is_array($response->items)) {
            foreach ($response->items as $channel) {
                $results[] = self::getChannelArray($channel);
            }
        }

        return $results;
    }
    
    /**
     * Converts trunk object to array
     * 
     * @param stdClass $trunk Trunk
     * @return array Trunk
     */
    static private function getTrunkArray(stdClass $trunk = null)
    {
        if ($trunk === null) {
            return null;
        }

        $result = array();
        $result['id'] = $trunk->id;
        $result['nr'] = $trunk->nr;
        $result['name'] = $trunk->name;
        return $result;
    }
    
    /**
     * Converts channel object to array
     * 
     * @param stdClass $channel Channel
     * @return array Channel
     */
    static private function getChannelArray(stdClass $channel)
    {
        $item = array();
        $item['id'] = $channel->id;
        $item['technology'] = $channel->technology;
        $item['name'] = $channel->name;
        $item['trunk'] = $channel->trunk;
        $item['state'] = $channel->state;
        $item['technology'] = $channel->technology;
        $item['number'] = $channel->phoneNumber;

        switch ($channel->state) {
            case 'UP':
                if ($channel->detailsUP) {
                    $item['bridged_id'] = $channel->detailsUP->bridgedChannelID;
                    $item['billsec'] = $channel->detailsUP->billsec;
                }
                break;
        }

        return $item;
    }
}
