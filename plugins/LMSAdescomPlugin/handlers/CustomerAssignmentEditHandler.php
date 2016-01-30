<?php

/**
 * CustomerAssignmentEditHandler
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class CustomerAssignmentEditHandler
{

    /**
     * Returns liability history
     * 
     * @param array $liability Liability
     * @param int $id History id
     * @return array|null Liability history
     */
    function get_liability_history($liability, $id)
    {
        foreach ($liability['history'] as $history) {
            if ($history['id'] == $id) {
                return $history;
            }
        }

        return null;
    }

    /**
     * Updates liability
     * 
     * @param array $liability Liability
     * @param int $id History id
     * @param array $history History
     * @return boolean True on success, false otherwise
     */
    function update_liability_history(&$liability, $id, $history)
    {
        foreach ($liability['history'] as $key => $old_history) {
            if ($old_history['id'] == $id) {
                $liability['history'][$key] = $history;
                return true;
            }
        }

        return false;
    }

    /**
     * Updates liability list
     * 
     * @global Smarty $SMARTY Smarty
     * @param int $clientid Client id
     * @param string $name Liability name
     * @return \xajaxResponse Response
     */
    function update_list($clientid, $name)
    {
        global $SMARTY;

        $liability_manager = new AdescomLiabilityManager();
        $liability = $liability_manager->getClientLiability($clientid, $name);

        $SMARTY->assign('adescom_liability', $liability);

        $output = $SMARTY->fetch('customerassignments_adescom_liability_history_list.html');

        $response = new xajaxResponse();

        $response->assign('adescom_assignments', 'innerHTML', $output);

        return $response;
    }

    /**
     * Adds Adescom assignment
     * 
     * @global Smarty $SMARTY Smarty
     * @global Session $SESSION Session
     * @param int $clientid Client id
     * @param string $name Assignment name
     * @param array $form Form
     * @return \xajaxResponse Response
     */
    function adescom_add_assignment($clientid, $name, $form)
    {
        global $SMARTY, $SESSION;

        if ($form && is_array($form)) {
            $form = array_shift($form);

            foreach ($form as $key => $value) {
                $form[$key] = trim($value);
            }

            $errors = array();

            if ($form['subscribe_value'] == '') {
                $error['subscribe_value'] = trans('Subscribe value is required');
            }

            if ($form['subscribe_date'] == '') {
                $error['subscribe_date'] = trans('Subscribe change date is required');
            } elseif (preg_match('/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/', $form['subscribe_date'])) {
                list($y, $m, $d) = explode('/', $form['subscribe_date']);

                if (checkdate($m, $d, $y)) {
                    $subscribe_date = mktime(23, 59, 59, $m, $d, $y);
                } else {
                    $error['subscribe_date'] = trans('Incorrect subscribe change date!');
                }
            } else {
                $error['subscribe_date'] = trans('Incorrect subscribe change date!');
            }

            if (empty($error)) {
                $SESSION->restore('adescom_assignment_clientid', $clientid);
                $SESSION->restore('adescom_assignment_name', $name);

                
                $liability_manager = new AdescomLiabilityManager();
                $liability = $liability_manager->getClientLiability($clientid, $name);

                $liability['fraction'] = 'SUBSCRIBE';
                $liability['history'][] = array('date' => $subscribe_date, 'price' => $form['subscribe_value']);

                $liability_manager->setClientLiability($clientid, $name, $liability);

                return $this->update_list($clientid, $name);
            }

            $SMARTY->assign('error', $error);
        } else {
            $SESSION->save('adescom_assignment_clientid', $clientid);
            $SESSION->save('adescom_assignment_name', $name);

            $form = array('subscribe_date' => date('Y/m/d'), 'subscribe_value' => 0);
        }

        $SESSION->close();

        $SMARTY->assign('history', $form);
        $SMARTY->assign('is_edit', false);

        $output = $SMARTY->fetch('customerassignments_adescom_liability_history_form.html');

        $response = new xajaxResponse();

        $response->assign('adescom_assignments', 'innerHTML', $output);

        return $response;
    }

    /**
     * Edits Adescom assignment
     * 
     * @global Smarty $SMARTY Smarty
     * @global Session $SESSION Session
     * @param int $clientid Client id
     * @param string $name Assignment name
     * @param int $id History id
     * @param array $form Form
     * @return \xajaxResponse Response
     */
    function adescom_edit_assignment($clientid, $name, $id, $form)
    {
        global $SMARTY, $SESSION;

        $liability_manager = new AdescomLiabilityManager();
        
        if ($form && is_array($form)) {
            $form = array_shift($form);

            foreach ($form as $key => $value) {
                $form[$key] = $value;
            }

            $errors = array();

            if ($form['subscribe_value'] == '') {
                $error['subscribe_value'] = trans('Subscribe value is required');
            }

            if ($form['subscribe_date'] == '') {
                $error['subscribe_date'] = trans('Subscribe change date is required');
            } elseif (preg_match('/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/', $form['subscribe_date'])) {
                list($y, $m, $d) = explode('/', $form['subscribe_date']);

                if (checkdate($m, $d, $y)) {
                    $subscribe_date = mktime(23, 59, 59, $m, $d, $y);
                } else {
                    $error['subscribe_date'] = trans('Incorrect subscribe change date!');
                }
            } else {
                $error['subscribe_date'] = trans('Incorrect subscribe change date!');
            }

            if (empty($error)) {
                $SESSION->restore('adescom_assignment_clientid', $clientid);
                $SESSION->restore('adescom_assignment_name', $name);
                $SESSION->restore('adescom_assignment_history_id', $id);

                

                $liability = $liability_manager->getClientLiability($clientid, $name);

                $liability['fraction'] = 'SUBSCRIBE';

                $history = array();

                $history['date'] = strtotime($form['subscribe_date']);
                $history['price'] = $form['subscribe_value'];

                $this->update_liability_history($liability, $id, $history) ? 't' : 'f';

                $liability_manager->setClientLiability($clientid, $name, $liability);

                return $this->update_list($clientid, $name);
            }

            $SMARTY->assign('error', $error);
        } else {
            $SESSION->save('adescom_assignment_clientid', $clientid);
            $SESSION->save('adescom_assignment_name', $name);
            $SESSION->save('adescom_assignment_history_id', $id);

            $liability = $liability_manager->getClientLiability($clientid, $name);

            $history = $this->get_liability_history($liability, $id);

            $form = array('subscribe_date' => date('Y/m/d', $history['date']), 'subscribe_value' => $history['price']);
        }

        $SESSION->close();

        $SMARTY->assign('history', $form);
        $SMARTY->assign('is_edit', true);

        $output = $SMARTY->fetch('customerassignments_adescom_liability_history_form.html');

        $response = new xajaxResponse();

        $response->assign('adescom_assignments', 'innerHTML', $output);

        return $response;
    }

    /**
     * Deletes Adescom assignment
     * 
     * @global Smarty $SMARTY Smarty
     * @param type $clientid Client id
     * @param type $name Liability name
     * @param type $id Liability id
     * @return xajaxResponse Response
     */
    function adescom_delete_assignment($clientid, $name, $id)
    {
        global $SMARTY;
        
        $liability_manager = new AdescomLiabilityManager();

        $liability_manager->deleteClientLiability($clientid, $name, $id);

        return $this->update_list($clientid, $name);
    }

    /**
     * Cancels Adescom assignment
     * 
     * @global Session $SESSION Session
     * @return xajaxResponse Response
     */
    function adescom_cancel_assignment()
    {
        global $SESSION;

        $clientid = $SESSION->get('adescom_assignment_clientid');
        $name = $SESSION->get('adescom_assignment_name');

        return $this->update_list($clientid, $name);
    }

    /**
     * Adds some validation before customer assignment edit form is submitted
     * 
     * @param array $hook_data Hook data
     */
    public function customerAssignmentEditValidationBeforeSubmit(array $hook_data)
    {
        $hook_data['a']['origtariffid'] = $hook_data['a']['tariffid'];

        if ($hook_data['a']['tariffid'] == -3) {
            unset($hook_data['error']['name']);
            unset($hook_data['error']['value']);

            $hook_data['a']['name'] = 'ADESCOM_AUTO_VOIP_CALL';
            $hook_data['a']['value'] = 0.01;

            unset($hook_data['a']['tariffid']);
            unset($hook_data['a']['settlement']);
        }
        
        return $hook_data;
    }

    /**
     * Calls some Adescom webservices after customer assignment edit form is saved
     * 
     * @param array $hook_data Hook data
     */
    public function customerAssignmentEditAfterSubmit(array $hook_data)
    {
        if ($hook_data['a']['origtariffid'] == -3) {
            
            $db = LMSDB::getInstance();
            $db->Execute('UPDATE assignments SET tariffid = -3 WHERE id = ?', array($hook_data['a']['id']));
            
            $liability_manager = new AdescomLiabilityManager();
            $liability = $liability_manager->getClientLiability($hook_data['a']['customerid'], 'CLIENT_SUBSCRIBE');

            $liability['fraction'] = 'SUBSCRIBE';

            if (is_array($liability['history'])) {
                foreach ($liability['history'] as &$history) {
                    $liability['settlement'] = $hook_data['a']['subscribe_settlement'];
                }
            }

            $liability_manager->setClientLiability($hook_data['a']['customerid'], 'CLIENT_SUBSCRIBE', $liability);
        }
        
        return $hook_data;
    }

    /**
     * Adds some data to customer assignment edit form template
     * 
     * @param array $hook_data Hook data
     */
    public function customerAssignmentEditBeforeDisplay(array $hook_data)
    {
        $hook_data['a']['origtariffid'] = $hook_data['a']['tariffid'];

        if ($hook_data['a']['origtariffid'] == -3) {
            $liability_manager = new AdescomLiabilityManager();
            $liability = $liability_manager->getClientLiability($hook_data['a']['customerid'], 'CLIENT_SUBSCRIBE');

            $hook_data['smarty']->assign('adescom_liability', $liability);

            $hook_data['a']['tariffid'] = -3;
        }
        
        require_once(LIB_DIR . '/xajax/xajax_core/xajax.inc.php');
        $this->xajax = new xajax();
        $this->xajax->configure('errorHandler', true);
        $this->xajax->configure('javascript URI', 'img');
        $this->xajax->register(XAJAX_FUNCTION, array('adescom_delete_assignment', $this, 'adescom_delete_assignment'));
        $this->xajax->register(XAJAX_FUNCTION, array('adescom_edit_assignment', $this, 'adescom_edit_assignment'));
        $this->xajax->register(XAJAX_FUNCTION, array('adescom_add_assignment', $this, 'adescom_add_assignment'));
        $this->xajax->register(XAJAX_FUNCTION, array('adescom_cancel_assignment', $this, 'adescom_cancel_assignment'));
        $this->xajax->processRequest();

        $hook_data['smarty']->assign('xajax', $this->xajax->getJavascript());
        
        $hook_data['smarty']->assign('is_edit', true);
        
        return $hook_data;
    }

}
