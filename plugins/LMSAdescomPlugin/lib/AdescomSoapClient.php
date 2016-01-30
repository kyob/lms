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
 * AdescomSoapClient
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class AdescomSoapClient extends SoapClient
{

    /**
     * Calls webservice
     * 
     * @param string $function_name Function name
     * @param array $arguments Arguments
     * @return string Response
     */
    public function __call($function_name, $arguments)
    {
        $old_locale = setlocale(LC_ALL, "0");
        setlocale(LC_ALL, "C");
        $ret = parent::__call($function_name, $arguments);
        setlocale(LC_ALL, $old_locale);
        return $ret;
    }

    public function testConnection()
    {
        // do nothing
    }

}
