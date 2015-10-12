<?php

/**
 * ClidDefaults
 *
 * @package 
 * @author Maciej Lew <maciej.lew@adescom.pl>
 */
class ClidDefaults extends AdescomModelDefaults
{

    /**
     * Sets model default value
     * 
     * @param AdescomModel $model Model
     * @param boolean $force Force flag
     * @throws InvalidArgumentException if model is not an instance of Clid class
     */
    public function setDefaults(AdescomModel $model, $force = false)
    {
        if (!($model instanceof Clid)) {
            throw new InvalidArgumentException;
        }
        
        $this->setPorted($model, $force);
        $this->setCtmId($model, $force);
        $this->setRegistrationType($model, $force);
        $this->setPhoneId($model, $force);
        $this->setPhoneLine($model, $force);
        $this->setDisplayName($model, $force);
        $this->setEmail($model, $force);
        $this->setContext($model, $force);
        $this->setEmergencyContext($model, $force);
        $this->setHost($model, $force);
        $this->setHostName($model, $force);
        $this->setMacAddress($model, $force);
        $this->setSerialNumber($model, $force);
        $this->setVoiceMail($model, $force);
        $this->setVoiceMailPassword($model, $force);
        $this->setVoiceMailAttachment($model, $force);
        $this->setTariffId($model, $force);
        $this->setActive($model, $force);
        $this->setAutoactivationDate($model, $force);
        $this->setIsPrepaid($model, $force);
        $this->setPrepaidState($model, $force);
        $this->setAbsoluteCostLimit($model, $force);
        $this->setPoolId($model, $force);
        
        $clid_services = $model->getClidServices();
        if ($clid_services !== null) {
            $clid_services->setDefaults($force);
        }
        
    }

    public function setPorted(Clid $model, $force = false)
    {
        if ($force === true || $model->getPorted() === null) {
            $model->setPorted(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_ported')));
        }
    }

    public function setCtmId(Clid $model, $force = false)
    {
        if ($force === true || $model->getCtmId() === null) {
            $model->setCtmId(ConfigHelper::getConfig('adescom.default_clid_ctmid'));
        }
    }

    public function setRegistrationType(Clid $model, $force = false)
    {
        if ($force === true || $model->getRegistrationType() === null) {
            $model->setRegistrationType(ConfigHelper::getConfig('adescom.default_clid_registration_type'));
        }
    }

    public function setPhoneId(Clid $model, $force = false)
    {
        if ($force === true || $model->getPhoneId() === null) {
            $model->setPhoneId(ConfigHelper::getConfig('adescom.default_clid_phoneid'));
        }
    }

    public function setPhoneLine(Clid $model, $force = false)
    {
        if ($force === true || $model->getPhoneLine() === null) {
            $model->setPhoneLine(ConfigHelper::getConfig('adescom.default_clid_phone_line'));
        }
    }

    public function setDisplayName(Clid $model, $force = false)
    {
        if ($force === true || $model->getDisplayName() === null) {
            $model->setDisplayName(ConfigHelper::getConfig('adescom.default_clid_displayname'));
        }
    }

    public function setEmail(Clid $model, $force = false)
    {
        if ($force === true || $model->getEmail() === null) {
            $model->setEmail(ConfigHelper::getConfig('adescom.default_clid_email'));
        }
    }

    public function setContext(Clid $model, $force = false)
    {
        if ($force === true || $model->getContext() === null) {
            $model->setContext(ConfigHelper::getConfig('adescom.default_clid_context'));
        }
    }

    public function setEmergencyContext(Clid $model, $force = false)
    {
        if ($force === true || $model->getEmergencyContext() === null) {
            $model->setEmergencyContext(ConfigHelper::getConfig('adescom.default_clid_emergency_context'));
        }
    }

    public function setHost(Clid $model, $force = false)
    {
        if ($force === true || $model->getHost() === null) {
            $model->setHost(ConfigHelper::getConfig('adescom.default_clid_host'));
        }
    }

    public function setHostName(Clid $model, $force = false)
    {
        if ($force === true || $model->getHostName() === null) {
            $model->setHostName(ConfigHelper::getConfig('adescom.default_clid_hostname'));
        }
    }

    public function setMacAddress(Clid $model, $force = false)
    {
        if ($force === true || $model->getMacAddress() === null) {
            $model->setMacAddress(ConfigHelper::getConfig('adescom.default_clid_mac_address'));
        }
    }

    public function setSerialNumber(Clid $model, $force = false)
    {
        if ($force === true || $model->getSerialNumber() === null) {
            $model->setSerialNumber(ConfigHelper::getConfig('adescom.default_clid_serial_number'));
        }
    }

    public function setVoiceMail(Clid $model, $force = false)
    {
        if ($force === true || $model->getVoiceMail() === null) {
            $model->setVoiceMail(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_voicemail')));
        }
    }

    public function setVoiceMailPassword(Clid $model, $force = false)
    {
        if ($force === true || $model->getVoiceMailPassword() === null) {
            $model->setVoiceMailPassword(ConfigHelper::getConfig('adescom.default_clid_voicemailpassword'));
        }
    }

    public function setVoiceMailAttachment(Clid $model, $force = false)
    {
        if ($force === true || $model->getVoiceMailAttachment() === null) {
            $model->setVoiceMailAttachment(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_voicemailattach')));
        }
    }

    public function setTariffId(Clid $model, $force = false)
    {
        if ($force === true || $model->getTariffId() === null) {
            $model->setTariffId(ConfigHelper::getConfig('adescom.default_clid_tariffid'));
        }
    }

    public function setActive(Clid $model, $force = false)
    {
        if ($force === true || $model->getActive() === null) {
            $model->setActive(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_active')));
        }
    }

    public function setAutoactivationDate(Clid $model, $force = false)
    {
        if ($force === true || $model->getAutoactivationDate() === null) {
            $model->setAutoactivationDate(ConfigHelper::getConfig('adescom.default_clid_autoactivation_date'));
        }
    }

    public function setIsPrepaid(Clid $model, $force = false)
    {
        if ($force === true || $model->getIsPrepaid() === null) {
            $model->setIsPrepaid(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_is_prepaid')));
        }
    }

    public function setPrepaidState(Clid $model, $force = false)
    {
        if ($force === true || $model->getPrepaidState() === null) {
            $model->setPrepaidState(ConfigHelper::getConfig('adescom.default_clid_prepaid_state'));
        }
    }

    public function setAbsoluteCostLimit(Clid $model, $force = false)
    {
        if ($force === true || $model->getAbsoluteCostLimit() === null) {
            $model->setAbsoluteCostLimit(ConfigHelper::getConfig('adescom.default_clid_absolute_cost_limit'));
        }
    }
    
    public function setPoolId(Clid $model, $force = false)
    {
        if ($force === true || $model->getPoolId() === null) {
            $model->setPoolId(ConfigHelper::getConfig('adescom.default_clid_poolid'));
        }
    }

}
