<?php

/**
 * ClidValidator
 *
 * @package 
 * @author Maciej Lew <maciej.lew@adescom.pl>
 */
class ClidValidator extends AdescomModelValidator
{
    /**
     * Validates model
     * 
     * @param \AdescomModel $model Model
     * @throws InvalidArgumentException if model is not an instance of Clid class
     */
    public function validate(AdescomModel $model)
    {
        if (!($model instanceof Clid)) {
            throw new InvalidArgumentException;
        }
        
        $this->errors = array();
        
        $isActive = $model->getActive();
        $isPorted = $model->getPorted();
        $isPrepaid = $model->getIsPrepaid();
        
        $this->validatePasswd($model);
        if (!$isActive && !$isPorted) {
            $autoActivation = $model->getAutoactivationDate();
            if (!empty($autoActivation)) {
                $this->validateAutoactivationDate($model);
            }
        }
        $this->validateCountryCode($model);
        $this->validateAreaCode($model);
        $this->validateShortCLID($model);
        
        $this->validateCTMID($model);
        $this->validatePhoneId($model);
        $this->validateLine($model);
        $this->validateContext($model);
        $this->validateEmergencyContext($model);
        $this->validateHost($model);
        $this->validateRegistrationType($model);
        $this->validateTariffId($model);
        $this->validateMACAddress($model);
        
        if ($isPrepaid) {
            $prepaidState = $model->getPrepaidState();
            if (empty($prepaidState)) {
                $this->errors['prepaid_state'] = trans('You must enter prepaid VOIP account state!');
            } else {
                $this->validatePrepaidState($model);
            }
        } elseif ($model->getAbsoluteCostLimit()) {
            $this->validateAbsoluteCostLimit($model);
        }
        
    }

    public function validateAbsoluteCostLimit(Clid $model)
    {
        if (!is_numeric($model->getAbsoluteCostLimit())) {
            $this->errors['absolute_cost_limit'] = trans('Absolute monthly limit must be a numeric value!');
        }
    }

    public function validateActive(Clid $model)
    {
        
    }

    public function validateAreaCode(Clid $model)
    {
        if (!$model->getAreaCode()) {
            $this->errors['phone'] = trans('Voip account phone number is required! 1');
        }
    }

    public function validateAutoactivationDate(Clid $model)
    {
        if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/i', $model->getAutoactivationDate())) {
            $this->errors['autoactivation_date'] = trans('Specified date is invalid!');
        }
    }

    public function validateCTMID(Clid $model)
    {
        if (!$model->getCtmId()) {
            $this->errors['ctmid'] = trans('You must select CTM node!');
        }
    }

    public function validateContext(Clid $model)
    {
        if (!$model->getContext()) {
            $this->errors['context'] = trans('Context group is required!');
        }
    }

    public function validateCountryCode(Clid $model)
    {
        if (!$model->getCountryCode()) {
            $this->errors['phone'] = trans('Voip account phone number is required! 0');
        }
    }

    public function validateHost(Clid $model)
    {
        if (!$model->getHost()) {
            $this->errors['host'] = trans('Host IP address is required!');
        }
    }

    public function validateId(Clid $model)
    {
        
    }

    public function validateLine(Clid $model)
    {
        if (!$model->getLine()) {
            $this->errors['line'] = trans('You must select phone line!');
        }
    }

    public function validateLogin(Clid $model)
    {
        
    }

    public function validateMACAddress(Clid $model)
    {
        $mac = $model->getMacAddress();
        if ($mac && !check_mac($mac)) {
            $this->errors['mac_address'] = trans('Incorrect MAC address!');
        }
    }

    public function validatePasswd(Clid $model)
    {
        if (!preg_match('/^[_a-z0-9-!@#$%^&*?]+$/i', $model->getPasswd())) {
            $this->errors['passwd'] = trans('Specified password contains forbidden characters!');
        }
    }

    public function validatePhone(Clid $model)
    {
        
    }

    public function validatePhoneId(Clid $model)
    {
        if (!$model->getPhoneId()) {
            $this->errors['phoneid'] = trans('You must select phone profile!');
        }
    }

    public function validatePorted(Clid $model)
    {
        
    }

    public function validatePrepaidState(Clid $model)
    {
        if (!is_numeric($model->getPrepaidState())) {
            $this->errors['prepaid_state'] = trans('Prepaid VOIP account state must be a numeric value!');
        }
    }

    public function validateShortCLID(Clid $model)
    {
        if (!$model->getShortClid()) {
            $this->errors['phone'] = trans('Voip account phone number is required! 2');
        }
    }

    public function validateEmergencyContext(Clid $model)
    {
        if (!$model->getEmergencyContext()) {
            $this->errors['emergencycontext'] = trans('Emergency context group is required!');
        }
    }

    public function validateRegistrationType(Clid $model)
    {
        if (!$model->getRegistrationType()) {
            $this->errors['registration_type'] = trans('You must select registration type!');
        }
    }

    public function validateTariffId(Clid $model)
    {
        if (!$model->getTariffId()) {
            $this->errors['tariffid'] = trans('You must select CLID tariff!');
        }
    }

    public function validateIsPrepaid(Clid $model)
    {
        
    }

    
}
