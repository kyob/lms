<?php

/**
 * AdescomLMSCustomerManager
 *
 * @package 
 * @author Maciej Lew <maciej.lew@adescom.pl>
 */
class AdescomLMSCustomerManager extends LMSCustomerManager
{
    /**
     * Deletes customer
     * 
     * @param int $id Customer id
     */
    public function deleteCustomer($id)
    {
        $this->db->BeginTrans();
        parent::deleteCustomer($id);
        $client_manager = new AdescomClientManager();
        try {
            $client = $client_manager->getClient($id);
            if ($client) {
                $client_manager->deleteClient($id);
            } 
        } catch (Exception $ex) {
            $this->db->RollbackTrans();
            error_log('Cannot delete customer via Adescom webservice! '.$ex->getMessage());
            header('Location: ?m=adescom_error');
            die;
        }
        $this->db->CommitTrans();
    }
}
