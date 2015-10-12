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
 * CustomerAssignmentAddHandler
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class CustomerAssignmentAddHandler
{

    /**
     * Adds some validation before customer assignment is submitted
     * 
     * @param array $hook_data Hook data
     * @return array Hook data
     */
    public function customerAssignmentAddValidationBeforeSubmit(array $hook_data)
    {
        $hook_data['a']['origtariffid'] = $hook_data['a']['tariffid'];

        if ($hook_data['a']['tariffid'] == AdescomFinanceManager::ADESCOM_TARIFF_ID) {
            unset($hook_data['error']['name']);
            unset($hook_data['error']['value']);

            $hook_data['a']['name'] = AdescomFinanceManager::ADESCOM_ASSIGNMENT_NAME;
            $hook_data['a']['origtariffid'] = AdescomFinanceManager::ADESCOM_TARIFF_ID;
            $hook_data['a']['tariffid'] = AdescomFinanceManager::ADESCOM_TARIFF_ID;
            $hook_data['a']['value'] = '0.01';

            unset($hook_data['a']['settlement']);
        }
        
        
        return $hook_data;
    }
    
    /**
     * Adds some data to customer assignment add form template
     * 
     * @param array $hook_data Hook data
     * @return array Hook data
     */
    public function customerAssignmentAddBeforeDisplay(array $hook_data)
    {
        $hook_data['smarty']->assign('is_edit', false);
        return $hook_data;
    }

}
