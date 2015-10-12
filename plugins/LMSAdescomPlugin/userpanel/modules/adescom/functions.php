<?php

/*
 *  LMS version 1.11-cvs
 *
 *  (C) Copyright 2001-2010 LMS Developers
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
 *  $Id: functions.php,v 1.6 2010/03/11 13:07:55 alec Exp $
 */

function module_external_login()
{
    global $SMARTY,$SESSION;
    $userpanel_manager = new AdescomUserpanelManager();
    $username = $userpanel_manager->userpanelGetExternalUserName($SESSION->id);
    if ($username === null) {
        return;
    }
    $response = $userpanel_manager->userpanelExternalLogin($username, 'superuser');
    if ($response === null) {
        return;
    }
    $SMARTY->assign('url', ConfigHelper::getConfig('adescom.userpanel_login_url'));
    $SMARTY->assign('sessionID', $response->sessionID);
    $SMARTY->assign('challengeHash', $response->challengeHash);
    $SMARTY->display('module:external_login.html');
}

function module_main()
{
    module_external_login();
}
