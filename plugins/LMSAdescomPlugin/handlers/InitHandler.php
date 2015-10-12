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
 * InitHandler
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class InitHandler
{

    /**
     * Sets plugin managers
     * 
     * @param LMS $hook_data Hook data
     */
    public function lmsInit(LMS $hook_data)
    {
        $hook_data->setFinanaceManager(
            new AdescomFinanceManager(
                $hook_data->getDb(), $hook_data->getAuth(), $hook_data->getCache(), $hook_data->getSyslog()
            )
        );
        $hook_data->setVoipAccountManager(
            new AdescomVoipAccountManager(
                $hook_data->getDb(), $hook_data->getAuth(), $hook_data->getCache(), $hook_data->getSyslog()
            )
        );
        $hook_data->setCustomerManager(
            new AdescomLMSCustomerManager(
                $hook_data->getDb(), $hook_data->getAuth(), $hook_data->getCache(), $hook_data->getSyslog()
            )
        );
        return $hook_data;
    }

    /**
     * Sets plugin Smarty templates directory
     * 
     * @param Smarty $hook_data Hook data
     * @return \Smarty Hook data
     */
    public function smartyInit(Smarty $hook_data)
    {
        $hook_data->registerPlugin('modifier', 'secs2hms', array('DateTimeHelper', 'secsToHms'));
        
        $template_dirs = $hook_data->getTemplateDir();
        $plugin_templates = PLUGINS_DIR . DIRECTORY_SEPARATOR . LMSAdescomPlugin::PLUGIN_DIRECTORY_NAME . DIRECTORY_SEPARATOR . 'templates';
        array_unshift($template_dirs, $plugin_templates);
        $hook_data->setTemplateDir($template_dirs);
        return $hook_data;
    }

    /**
     * Sets plugin Smarty modules directory
     * 
     * @param array $hook_data Hook data
     * @return array Hook data
     */
    public function modulesDirInit(array $hook_data = array())
    {
        $plugin_modules = PLUGINS_DIR . DIRECTORY_SEPARATOR . LMSAdescomPlugin::PLUGIN_DIRECTORY_NAME . DIRECTORY_SEPARATOR . '/modules';
        array_unshift($hook_data, $plugin_modules);
        return $hook_data;
    }

    /**
     * Sets plugin menu entries
     * 
     * @param array $hook_data Hook data
     * @return array Hook data
     */
    public function menuInit(array $hook_data = array())
    {
        $adescom_submenus = array(
            array(
                'name' => trans('Adescom VoIP settings'),
                'link' => '?m=voipsettings',
                'tip' => trans('Allows you to set some global VOIP settings'),
                'prio' => 100,
            ),
        );
        $hook_data['VoIP']['submenu'] = array_merge($hook_data['VoIP']['submenu'], $adescom_submenus);
        return $hook_data;
    }

}
