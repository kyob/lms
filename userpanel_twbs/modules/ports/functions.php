<?php

/*
 *  LMS version 1.11-git
 *
 *  (C) Copyright 2001-2012 LMS Developers
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

function module_main()
{
    global $DB,$LMS,$SESSION,$SMARTY;

$ip = getenv('HTTP_CLIENT_IP')?:
getenv('HTTP_X_FORWARDED_FOR')?:
getenv('HTTP_X_FORWARDED')?:
getenv('HTTP_FORWARDED_FOR')?:
getenv('HTTP_FORWARDED')?:
getenv('REMOTE_ADDR');

    //list of port numbers to scan
    $ports = array(21, 22, 23, 25, 53, 67, 68, 69, 80, 110, 111, 115, 123, 135, 138, 139, 143, 161, 162, 194, 443, 445, 500, 514, 520, 631, 993, 995, 1433, 1434, 1723, 1900, 3306, 3389, 4500, 5632, 5900, 6112, 8080);
    
    $results = array();
    foreach($ports as $port) {
        if($pf = @fsockopen($ip, $port, $err, $err_string, 1)) {
            $results[$port] = 1;
            fclose($pf);
        } else {
            $results[$port] = 0;
        }
    }
 
    foreach($results as $port=>$val)    {
        $prot = getservbyport($port,"tcp");
	$porty[]=array('port'=>$port,'protokol'=>$prot,'status'=>$val);
    }

    //echo '<pre>';print_r($porty);echo '</pre>';

	$SMARTY->assign('ip', $ip);
	$SMARTY->assign('ports', $porty);

    $SMARTY->display('module:skaner_portow.html');
}

?>
