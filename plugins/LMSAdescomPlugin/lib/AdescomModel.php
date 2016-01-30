<?php

/**
 * AdescomModel
 * 
 * @package
 * @author Maciej Lew <maciej.lew@adescom.pl>
 */
abstract class AdescomModel
{
    /**
     * Fills model from array
     * 
     * @param array $model AdescomModel
     */
    abstract public function fromArray(array $model);
    
    /**
     * Converts model to array
     * 
     * @param array $model AdescomModel
     * @return array AdescomModel
     */
    abstract public function toArray(array $model = array());
}
