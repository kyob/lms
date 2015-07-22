<?php

/*
 * LMS version 1.11-git
 *
 *  (C) Copyright 2001-2013 LMS Developers
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

function GetEventListNotClosed($userid)
{
	global $DB, $AUTH;
/*
SELECT users.login, eventassignments.userid, count(eventassignments.userid) AS opened
 FROM eventassignments 
LEFT JOIN events ON (eventassignments.eventid=events.id) 
LEFT JOIN users ON (eventassignments.userid=users.id) 
WHERE events.closed=0 
GROUP BY eventassignments.userid
*/
	$list2 = $DB->GetAll(
		'SELECT events.id AS id, title, description, date, begintime, enddate, endtime, customerid, closed, '
		.$DB->Concat('UPPER(customers.lastname)',"' '",'customers.name').' AS customername,
		userid, users.name AS username, customers.address, nodes.location AS location
		FROM events 
		LEFT JOIN customers ON (customerid = customers.id)
		LEFT JOIN users ON (userid = users.id)
		LEFT JOIN nodes ON (customerid = nodes.ownerid)
		LEFT JOIN eventtagassignments ON (events.id = eventtagassignments.eventid)
		WHERE userid = '.intval($userid).' AND closed = 0
		 GROUP BY id ORDER BY date, begintime');

	$list = $DB->GetAll('
		SELECT events.id AS id, title, description, date, begintime, enddate, endtime, closed, events.userid AS userid, users.name AS username
		FROM events
 		LEFT JOIN users ON (userid = users.id)
		LEFT JOIN eventassignments ON (events.id = eventassignments.eventid)
		WHERE eventassignments.userid = '.intval($userid).' AND events.closed = 0
		 GROUP BY id ORDER BY date, begintime');

	return $list;
}

if(!isset($_GET['userid']))
	$SESSION->restore('eluserid', $userid);
else
	$userid = $_GET['userid'];
$SESSION->save('eluserid', $userid);


$layout['pagetitle'] = trans('Timetable');

$eventlist = GetEventListNotClosed($userid);

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$SMARTY->assign('openeventslist', $DB->GetAll('SELECT users.login, eventassignments.userid, count(eventassignments.userid) AS opened FROM eventassignments LEFT JOIN events ON (eventassignments.eventid=events.id) LEFT JOIN users ON (eventassignments.userid=users.id) WHERE events.closed=0 GROUP BY eventassignments.userid'));
//$SMARTY->assign('openeventslist', $DB->GetAll('SELECT userid, COUNT(userid) AS opened, users.login AS login FROM events LEFT JOIN users ON (events.userid=users.id) WHERE closed=0 GROUP BY userid'));
$SMARTY->assign('taglist', $LMS->GetEventTags());
$SMARTY->assign('period', $DB->GetRow('SELECT MIN(date) AS fromdate, MAX(date) AS todate FROM events'));
$SMARTY->assign('eventlist',$eventlist);
$SMARTY->assign('userlist',$LMS->GetUserNames());
$SMARTY->assign('customerlist',$LMS->GetCustomerNames());
$SMARTY->assign('current_userid',$_GET['userid']);
$SMARTY->display('event/eventlistnotclosed.html');

?>
