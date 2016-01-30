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
 * AdescomConnection
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class AdescomConnection
{

    const PLATFORM_WEBSERVICE = 'platform';
    const FRONTEND_WEBSERVICE = 'frontend';

    private static $connection;

    /**
     * Returns Adescom webservice connection
     * 
     * @return AdescomConnection Connection
     */
    public static function getConnection()
    {
        if (self::$connection === null) {
            // connect to our Webservices
            self::$connection = new AdescomSoapClient(
                ConfigHelper::getConfig('adescom.wsdl_url'), 
                array(
                    'location' => ConfigHelper::getConfig('adescom.location_url'),
                    'soap_version' => SOAP_1_1,
                    'features' => SOAP_SINGLE_ELEMENT_ARRAYS | SOAP_USE_XSI_ARRAY_TYPE
                )
            );

            // login using provided username and password
            $session_id = self::$connection->login(
                ConfigHelper::getConfig('adescom.username'),
                ConfigHelper::getConfig('adescom.password'), 
                3600
            );

            // use returned sessionID for further calls
            self::$connection->__setCookie('sessionID', $session_id);
        }

        // finally return SOAP client object
        return self::$connection;
    }

}
