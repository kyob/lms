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

if (isset($_GET['nodegroups'])) {
	$nodegroups = $LMS->GetNodeGroupNamesByNode(intval($_GET['id']));

	$SMARTY->assign('nodegroups', $nodegroups);
	$SMARTY->assign('total', sizeof($nodegroups));
	$SMARTY->display('node/nodegrouplistshort.html');
	die;
}

if (!preg_match('/^[0-9]+$/', $_GET['id'])) {
	$SESSION->redirect('?m=nodelist');
}
else
	$nodeid = $_GET['id'];

if (!$LMS->NodeExists($nodeid)) {
	if (isset($_GET['ownerid']))
		$SESSION->redirect('?m=customerinfo&id=' . $_GET['ownerid']);
	else if ($DB->GetOne('SELECT 1 FROM vnodes WHERE id = ? AND ownerid = 0', array($nodeid)))
		$SESSION->redirect('?m=netdevinfo&ip=' . $nodeid . '&id=' . $LMS->GetNetDevIDByNode($nodeid));
	else
		$SESSION->redirect('?m=nodelist');
}

if (isset($_GET['devid'])) {
	$error['netdev'] = trans('It scans for free ports in selected device!');
	$SMARTY->assign('error', $error);
	$SMARTY->assign('netdevice', $_GET['devid']);
}

$nodeinfo = $LMS->GetNode($nodeid);
$nodegroups = $LMS->GetNodeGroupNamesByNode($nodeid);
$othernodegroups = $LMS->GetNodeGroupNamesWithoutNode($nodeid);
$customerid = $nodeinfo['ownerid'];

include(MODULES_DIR . '/customer.inc.php');

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

if (!isset($_GET['ownerid']))
	$SESSION->save('backto', $SESSION->get('backto') . '&ownerid=' . $customerid);

if ($nodeinfo['netdev'] == 0)
	$netdevices = $LMS->GetNetDevNames();
else
	$netdevices = $LMS->GetNetDev($nodeinfo['netdev']);

$layout['pagetitle'] = trans('Node Info: $a', $nodeinfo['name']);

$nodeinfo['projectname'] = trans('none');
if ($nodeinfo['invprojectid']) {
	$prj = $DB->GetRow("SELECT * FROM invprojects WHERE id=?", array($nodeinfo['invprojectid']));
	if ($prj) {
		if ($prj['type'] == INV_PROJECT_SYSTEM && intval($prj['id']==1)) {
			/* inherited */ 
			if ($nodeinfo['netdev']) {
				$prj = $DB->GetRow("SELECT * FROM invprojects WHERE id=?",
					array($netdevices['invprojectid']));
				if ($prj) {
					if ($prj['type'] == INV_PROJECT_SYSTEM && intval($prj['id'])==1) {
						/* inherited */
						if ($netdevices['netnodeid']) {
							$prj = $DB->GetRow("SELECT p.*, n.name AS nodename FROM invprojects p
								JOIN netnodes n ON n.invprojectid = p.id
								WHERE n.id=?",
								array($netdevices['netnodeid']));
							if ($prj)
								$nodeinfo['projectname'] = trans('$a (from network node $b)', $prj['name'], $prj['nodename']);
						}
					} else
						$nodeinfo['projectname'] = trans('$a (from network device $b)', $prj['name'], $netdevices['name']);
				}
			}
		} else
			$nodeinfo['projectname'] = $prj['name'];
	}
}
$nodeauthtype = array();
$authtype = $nodeinfo['authtype'];
if ($authtype != 0) {
	$nodeauthtype['pppoe'] = ($authtype & 1);
	$nodeauthtype['dhcp'] = ($authtype & 2);
	$nodeauthtype['eap'] = ($authtype & 4);
}

// REDBACK CLIPS
function NodeLastPPPoESession($id) {
    global $DB;
    if ($PPPoESession = $DB->GetRow('SELECT callingstationid, nasipaddress, acctstarttime, acctstoptime, acctsessiontime, acctinputoctets, acctoutputoctets, framedipaddress FROM radacct WHERE username=? ORDER BY radacctid DESC LIMIT 1', array($id))) {

        list($PPPoESession['upload'], $PPPoESession['uploadunit']) = setunits($PPPoESession['acctinputoctets']);
        list($PPPoESession['download'], $PPPoESession['downloadunit']) = setunits($PPPoESession['acctoutputoctets']);
        $PPPoESession['acctsessiontimeconv'] = date("z \d\\n\i H:i:s", -3600 + $PPPoESession['acctsessiontime']);
        if ($PPPoESession['acctstoptime'] == 0)
            $PPPoESession['acctstoptime'] = 'TRWA';
        else
            $PPPoESession['acctstoptime'] = "zakonczona: " . $PPPoESession['acctstoptime'];
    }
    return $PPPoESession;
}

$nodeinfo = $LMS->GetNode($nodeid);
$lastPPPoEsession = NodeLastPPPoESession($nodeinfo['macs'][0]['mac']);

function GetClipsInfo($mac) {
    global $CONFIG;
    $ip = $CONFIG['redback']['ip'];
    $user = $CONFIG['redback']['username'];
    $pass = $CONFIG['redback']['pass'];
    $port = $CONFIG['redback']['port'];

    $cmd = $CONFIG['redback']['info'] . " " . strtolower($mac);
    if (isset($CONFIG['redback']['pass'])) {
        $methods = array(
            'kex' => 'diffie-hellman-group1-sha1',
            'hostkey' => 'ssh-dss',
            'client_to_server' => array(
                'crypt' => '3des-cbc',
                'mac' => 'hmac-md5',
                'comp' => 'none'),
            'server_to_client' => array(
                'crypt' => '3des-cbc',
                'mac' => 'hmac-md5',
                'comp' => 'none'));

        $conn = ssh2_connect($ip, $port, $methods);
        $test = ssh2_auth_password($conn, $user, $pass);
        $stream = ssh2_exec($conn, $cmd);
        stream_set_blocking($stream, true);
        $return = stream_get_contents($stream);
        fclose($stream);
    }
    return $return;
}

function UpdateClips($nid) {
    global $DB, $CONFIG;
    $node = $DB->GetRow("SELECT lower(m.mac) AS mac,t.downceil AS dl_ceil, t.upceil AS up_ceil, CASE WHEN n.access = 0 OR n.warning = 1 THEN 1 ELSE 0 END AS redirect FROM nodeassignments na INNER JOIN assignments a ON (na.assignmentid = a.id) AND ((UNIX_TIMESTAMP() >= datefrom AND UNIX_TIMESTAMP() <= dateto) OR (UNIX_TIMESTAMP() >= datefrom AND dateto = 0)) INNER JOIN tariffs t ON (a.tariffid = t.id) INNER JOIN nodes n ON (na.nodeid = n.id) INNER JOIN macs m ON (m.nodeid = n.id) WHERE n.id = ?;", array($nid));
    
    if ($node[redirect] == 0) {
        $forwardpolicy = "in:CLIPS-DEFAULT";
        $httpredirect = "";
    } else {
        $forwardpolicy = "in:REDIRECT";
        $httpredirect = "KOMUNIKAT";
    }

    $nas = $CONFIG[redback][Identifier];
    $context = $CONFIG[redback][ClipsContext];
    $mac=$node[mac];

//    echo $cmd='echo "User-Name='.$mac.',Qos-Rate-Outbound='.$node[dl_ceil].', Qos-Rate-Inbound='.$node[up_ceil].',Forward-Policy='.$forwardpolicy.', HTTP-Redirect-Profile-Name=\''.$httpredirect.'\', Context-Name='.$context.'" | radclient -r 1 -x 91.231.70.33:3799 coa alfaradius';
    echo $cmd='echo "User-Name='.$mac.',Qos-Rate-Outbound='.$node[dl_ceil].', Qos-Rate-Inbound='.$node[up_ceil].',Forward-Policy='.$forwardpolicy.', HTTP-Redirect-Profile-Name=\''.$httpredirect.'\', Context-Name='.$context.'" | radclient -r 1 -x ' . $CONFIG['redback']['clipsip'] . ':3799 coa '. $CONFIG['redback']['radiuspass'];

    if (!exec($cmd, $result)) {
        print($result);
        return "cmd not executed: ";
    }else{
	return $node;
    }
}

function DeleteClips($nid) {
    global $DB;
    $node = $DB->GetRow("SELECT lower(m.mac) AS mac FROM nodes n INNER JOIN macs m ON (m.nodeid = n.id) WHERE n.id = ?;", array($nid));
    $mac=$node[mac];
    $cmd='echo "User-Name='.$mac.'" | radclient -r 1 -s -x 91.231.70.33:3799 disconnect alfaradius';

    if (!exec($cmd, $result)) {
        print($result);
    }else{
	$DB->exec("UPDATE radacct SET acctstoptime=NOW(), acctterminatecause='STATE-CLEARED' WHERE acctstoptime IS NULL AND username = UPPER(?);", array($mac));
        return true;
    }
}

// SSH CLIPS INFO
if (isset($_GET['clips'])) {
    $SMARTY->assign('ClipsInfo', GetClipsInfo($nodeinfo['macs'][0]['mac']));
}

// RADCLIENT: COA
if($_GET['updatenode']==1) {
    $SMARTY->assign('ClipsUpdate', UpdateClips($_GET['id']));
}

// RADCLIENT: DISCONNECT
if($_GET['disconnectnode']==1) {
    if(DeleteClips($_GET['id'])) {
	$SESSION->redirect('?m=nodeinfo&id='.$_GET['id']);
    }else{
    echo "deleteclips fail";
    }
}
$SMARTY->assign('lastpppoesession', $lastPPPoEsession);
// END REDBACK CLIPS 

include(MODULES_DIR . '/nodexajax.inc.php');

$nodeinfo = $LMS->ExecHook('node_info_init', $nodeinfo);

$hook_data = $LMS->executeHook('nodeinfo_before_display',
	array(
		'nodeinfo' => $nodeinfo,
		'smarty' => $SMARTY,
	)
);
$nodeinfo = $hook_data['nodeinfo'];

$SMARTY->assign('xajax', $LMS->RunXajax());

$SMARTY->assign('nodesessions', $LMS->GetNodeSessions($nodeid));
$SMARTY->assign('netdevices', $netdevices);
$SMARTY->assign('nodeauthtype', $nodeauthtype);
$SMARTY->assign('nodegroups', $nodegroups);
$SMARTY->assign('othernodegroups', $othernodegroups);
$SMARTY->assign('nodeinfo', $nodeinfo);
$SMARTY->assign('objectid', $nodeinfo['id']);
$SMARTY->display('node/nodeinfo.html');

?>
