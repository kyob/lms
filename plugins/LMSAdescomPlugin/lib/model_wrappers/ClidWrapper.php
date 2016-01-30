<?php

/**
 * ClidWrapper
 *
 * @package 
 * @author Maciej Lew <maciej.lew@adescom.pl>
 */
class ClidWrapper extends AdescomModelWrapper
{
    /**
     * Constructs clid wrapper
     */
    public function __construct()
    {
        $this->model = new Clid();
        $this->validator = new ClidValidator();
        $this->defaults = new ClidDefaults();
    }

    /**
     * Prepares phone
     */
    public function preparePhone()
    {
        $this->model->preparePhone();
    }
    
    /**
     * Prepares login
     */
    public function prepareLogin()
    {
        $this->model->prepareLogin();
    }
    
}
