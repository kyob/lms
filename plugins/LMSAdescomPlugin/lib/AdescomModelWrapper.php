<?php

/**
 * AdescomModelWrapper
 *
 * @package 
 * @author Maciej Lew <maciej.lew@adescom.pl>
 */
abstract class AdescomModelWrapper
{
    /** @var AdescomModel AdescomModel */
    protected $model;
    
    /** @var AdescomModelValidator Validator */
    protected $validator;
    
    /** @var AdescomModelDefaults Defaults */
    protected $defaults;
    
    /**
     * Fills model from array
     * 
     * @param array $model AdescomModel
     */
    public function fromArray(array $model)
    {
        $this->model->fromArray($model);
    }
    
    /**
     * Converts model to array
     * 
     * @param array $model AdescomModel
     * @return array AdescomModel
     */
    public function toArray(array $model = array())
    {
        return $this->model->toArray($model);
    }
    
    /**
     * Validates model
     */
    public function validate()
    {
        $this->validator->validate($this->model);
    }
    
    /**
     * Returns model errors
     * 
     * @return array Errors
     */
    public function getErrors()
    {
        return $this->validator->getErrors();
    }
    
    /**
     * Sets model default value
     * 
     * @param boolean $force Force flag
     */
    public function setDefaults($force = false)
    {
        $this->defaults->setDefaults($this->model, $force);
    }
}
