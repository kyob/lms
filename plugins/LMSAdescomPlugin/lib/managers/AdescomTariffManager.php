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
 * AdescomTariffManager
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class AdescomTariffManager
{
    /**
     * Returns tariffs
     * 
     * @param AdescomSoapClient $connection Connection
     * @return array Tariffs
     */
    public function getTariffs(AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $response = $connection->getTariffs();

        $results = array();

        if (is_array($response->tariffs)) {
            foreach ($response->tariffs as $tariff) {
                $results[] = array('id' => $tariff->tariffID, 'name' => $tariff->name);
            }
        }
        if (is_array($response->items)) {
            foreach ($response->items as $tariff) {
                $results[] = array('id' => $tariff->id, 'name' => $tariff->name);
            }
        }
        return $results;
    }
}
