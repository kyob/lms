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
 * ArrayHelper
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class ArrayHelper
{
    /**
     * Returns array value for specified key or default value
     * 
     * @param string $name Array key
     * @param mixed $array Array
     * @param mixed $default Default value
     * @return mixed
     */
    public static function arrayGetValue($name, $array, $default = null)
    {
        if (!is_array($array) || !array_key_exists($name, $array)) {
            return $default;
        }

        return $array[$name];
    }

    /**
     * Returns boolean representation of value in array at specified key
     * 
     * @param string $name Array key
     * @param mixed $array Array
     * @param mixed $default Default value
     * @return boolean
     */
    public static function arrayGetBool($name, $array, $default = false)
    {
        return (boolean) self::arrayGetValue($name, $array, $default);
    }

    /**
     * Returns string representation of value in array at specified key
     * 
     * @param string $name Array key
     * @param mixed $array Array
     * @param mixed $default Default value
     * @return string
     */
    public static function arrayGetString($name, $array, $default = '')
    {
        return (string) self::arrayGetValue($name, $array, $default);
    }

    /**
     * Returns associative array where keys are computed by given function
     * 
     * @param array $array Array
     * @param callable $func Function
     * @return array
     */
    public static function arrayToAssocFunc(array $array, $func)
    {
        $assoc = array();

        foreach ($array as $element) {
            $value = call_user_func_array(array($element, $func), array());
            $assoc[$value] = $element;
        }

        return $assoc;
    }

    /**
     * Returns associative array
     * 
     * @param array $array Array
     * @param string|int $key Key
     * @return array
     */
    public static function arrayToAssoc(array $array, $key)
    {
        $assoc = array();

        foreach ($array as $element) {
            $assoc[$element[$key]] = $element;
        }

        return $assoc;
    }

}
