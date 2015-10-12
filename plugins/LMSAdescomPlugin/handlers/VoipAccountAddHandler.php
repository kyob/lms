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
 * VoipAccountAddHandler
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class VoipAccountAddHandler extends VoipAccountHandlerAbstract
{

    private $xajax;

    /**
     * Triggers after phone is selected. Returns additional options.
     * 
     * @param int $phoneid Phone id
     * @param string $phone_line_templates Template name
     * @return \xajaxResponse Response
     */
    public function select_phone($phoneid, $phone_line_templates = null)
    {
        return parent::select_phone($phoneid, 'voipaccount/voipaccountlines.html');
    }
    
    /**
     * Adds some actions on load of VoIP account add module
     * 
     * @global Smarty $SMARTY Smarty
     * @global Session $SESSION Session
     * @return null
     */
    public function voipAccountAddOnLoad()
    {
        global $SMARTY, $SESSION;

        if (isset($_GET['ownerid'])) {
            $ownerid = $_GET['ownerid'];
        } elseif (isset($_POST['voipaccountdata']['ownerid'])) {
            $ownerid = $_POST['voipaccountdata']['ownerid'];
        } else {
            $ownerid = null;
        }

        if (isset($_POST['pool_search']) && $ownerid) {
            if (isset($_POST['voipaccountdata'])) {
                $SESSION->save('voipaccountdata', $_POST['voipaccountdata']);
            }

            $SESSION->save('pool_search_ref', '?m=voipaccountadd&ownerid=' . $ownerid . '&return=true');

            $SESSION->redirect('?m=poolsearch&pool=' . $_POST['pool_search']);

            die();
        }

        require_once(LIB_DIR . '/xajax/xajax_core/xajax.inc.php');
        $this->xajax = new xajax();
        $this->xajax->configure('errorHandler', true);
        $this->xajax->configure('javascript URI', 'img');
        $this->xajax->register(XAJAX_FUNCTION, array('select_phone', $this, 'select_phone'));
        $this->xajax->register(XAJAX_FUNCTION, array('pool_first_free', $this, 'pool_first_free'));
        $this->xajax->register(XAJAX_FUNCTION, array('generate_license', $this, 'generate_license'));
        $this->xajax->processRequest();

        $SMARTY->assign('xajax', $this->xajax->getJavascript());
        return;
    }

    /**
     * Adds some validation before VoIP add form is submitted
     * 
     * @param array $hook_data Hook data
     * @return array Hook data
     */
    public function voipAccountAddBeforeSubmit(array $hook_data)
    {
        $errors = !empty($hook_data['error']) ? $hook_data['error'] : array();
        
        unset($errors['login']);
        unset($errors['phone']);
        unset($errors['passwd']);
        
        $model = new ClidWrapper();
        $model->fromArray($hook_data['voipaccountdata']);
        $model->prepareLogin();
        $model->preparePhone();
        $model->validate();
        $errors = array_merge($errors, $model->getErrors());
        
        $hook_data['voipaccountdata'] = $model->toArray();
        $hook_data['error'] = $errors;
        return $hook_data;
    }

    /**
     * Calls some Adescom webservices after VoIP add form is saved
     * 
     * @param array $hook_data Hook data
     * @return array Hook data
     */
    public function voipAccountAddAfterSubmit($hook_data)
    {
        return $hook_data;
    }

    /**
     * Adds some data to VoIP add form template
     * 
     * @global Session $SESSION Session
     * @param array $hook_data Hook data
     * @return array Hook data
     */
    public function voipAccountAddBeforeDisplay(array $hook_data)
    {
        global $SESSION;
        
        $ctm_manager = new AdescomCTMManager();
        $phone_manager = new AdescomPhoneManager();
        $context_manager = new AdescomContextManager();
        $tariff_manager = new AdescomTariffManager();
        $pool_manager = new AdescomPoolManager();
        $clid_services_manager = new AdescomClidServiceManager();

        $ctms = $ctm_manager->getCTMNodes();
        $phones = $phone_manager->getPhones();
        $contexts = $context_manager->getContexts();
        $tariffs = $tariff_manager->getTariffs();
        $pools = $pool_manager->getAllPools();
        $blocklevels = $clid_services_manager->getBlockLevels();
        
        $hook_data['smarty']->assign('ctms', $ctms);
        $hook_data['smarty']->assign('phones', $phones);
        $hook_data['smarty']->assign('contexts', $contexts);
        $hook_data['smarty']->assign('voip_tariffs', $tariffs);
        $hook_data['smarty']->assign('pools', $pools);
        $hook_data['smarty']->assign('blocklevels', $blocklevels);

        if (isset($_GET['return'])) {
            $SESSION->restore('voipaccountdata', $hook_data['voipaccountdata']);	
	}
        
        $model = new ClidWrapper();
        $model->fromArray($hook_data['voipaccountdata']);
        $model->setDefaults();
        $hook_data['voipaccountdata'] = $model->toArray();
        
        return $hook_data;
    }

}
