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
 * LMSAdescomPlugin
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class LMSAdescomPlugin extends LMSPlugin
{
    const PLUGIN_NAME = 'LMS Adescom Plugin';
    const PLUGIN_AUTHOR = 'Maciej Lew &lt;maciej.lew@adescom.pl&gt;';
    const PLUGIN_DIRECTORY_NAME = 'LMSAdescomPlugin';
    
    public function registerHandlers()
    {
        $this->handlers = array(
            'lms_initialized' => array(
                'class' => 'InitHandler',
                'method' => 'lmsInit'
            ),
            'smarty_initialized' => array(
                'class' => 'InitHandler',
                'method' => 'smartyInit'
            ),
            'modules_dir_initialized' => array(
                'class' => 'InitHandler',
                'method' => 'modulesDirInit'
            ),
            'menu_initialized' => array(
                'class' => 'InitHandler',
                'method' => 'menuInit'
            ),
            'voipaccountadd_on_load' => array(
                'class' => 'VoipAccountAddHandler',
                'method' => 'voipAccountAddOnLoad'
            ),
            'voipaccountadd_before_submit' => array(
                'class' => 'VoipAccountAddHandler',
                'method' => 'voipAccountAddBeforeSubmit'
            ),
            'voipaccountadd_before_display' => array(
                'class' => 'VoipAccountAddHandler',
                'method' => 'voipAccountAddBeforeDisplay'
            ),
            'voipaccountedit_on_load' => array(
                'class' => 'VoipAccountEditHandler',
                'method' => 'voipAccountEditOnLoad'
            ),
            'voipaccountedit_before_submit' => array(
                'class' => 'VoipAccountEditHandler',
                'method' => 'voipAccountEditBeforeSubmit'
            ),
            'voipaccountedit_before_display' => array(
                'class' => 'VoipAccountEditHandler',
                'method' => 'voipAccountEditBeforeDisplay'
            ),
            'voipaccountinfo_before_display' => array(
                'class' => 'VoipAccountInfoHandler',
                'method' => 'voipAccountInfoBeforeDisplay'
            ),
            'voipaccountlist_before_display' => array(
                'class' => 'VoipAccountListHandler',
                'method' => 'voipAccountListBeforeDisplay'
            ),
            'customerassignmentadd_validation_before_submit' => array(
                'class' => 'CustomerAssignmentAddHandler',
                'method' => 'customerAssignmentAddValidationBeforeSubmit'
            ),
            'customerassignmentadd_before_display' => array(
                'class' => 'CustomerAssignmentAddHandler',
                'method' => 'customerAssignmentAddBeforeDisplay'
            ),
            'customerassignmentedit_validation_before_submit' => array(
                'class' => 'CustomerAssignmentEditHandler',
                'method' => 'customerAssignmentEditValidationBeforeSubmit'
            ),
            'customerassignmentedit_after_submit' => array(
                'class' => 'CustomerAssignmentEditHandler',
                'method' => 'customerAssignmentEditAfterSubmit'
            ),
            'customerassignmentedit_before_display' => array(
                'class' => 'CustomerAssignmentEditHandler',
                'method' => 'customerAssignmentEditBeforeDisplay'
            ),
        );
    }
}
