<?php

/**
 * ClidServicesDefaults
 *
 * @package 
 * @author Maciej Lew <maciej.lew@adescom.pl>
 */
class ClidServicesDefaults extends AdescomModelDefaults
{
    /**
     * Sets model default value
     * 
     * @param AdescomModel $model Model
     * @param boolean $force Force flag
     * @throws InvalidArgumentException if model is not an instance of ClidServices class
     */
    public function setDefaults(AdescomModel $model, $force = false)
    {
        if (!($model instanceof ClidServices)) {
            throw new InvalidArgumentException;
        }
        
        $this->setClip($model, $force);
        $this->setClir($model, $force);
        $this->setClirAllowed($model, $force);
        $this->setAcrej($model, $force);
        $this->setAcrejAllowed($model, $force);
        $this->setClirovr($model, $force);
        $this->setDnd($model, $force);
        $this->setDndAllowed($model, $force);
        $this->setHotline($model, $force);
        $this->setHotlineAllowed($model, $force);
        $this->setCw($model, $force);
        $this->setCwAllowed($model, $force);
        $this->setNway($model, $force);
        $this->setAlarm($model, $force);
        $this->setForwarding($model, $force);
        $this->setCfu($model, $force);
        $this->setCfb($model, $force);
        $this->setCfnr($model, $force);
        $this->setCfur($model, $force);
        $this->setF2m($model, $force);
        $this->setUf2m($model, $force);
        $this->setNrf2m($model, $force);
        $this->setBlindXfer($model, $force);
        $this->setAtXfer($model, $force);
        $this->setOcbAllowed($model, $force);
        $this->setOcb($model, $force);
        $this->setOcbPassword($model, $force);
    }

    public function setClip(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getClip() === null) {
            $model->setClip(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_clip')));
        }
    }

    public function setClir(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getClir() === null) {
            $model->setClir(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_clir')));
        }
    }

    public function setClirAllowed(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getClirAllowed() === null) {
            $model->setClirAllowed(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_clir_allowed')));
        }
    }

    public function setAcrej(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getAcrej() === null) {
            $model->setAcrej(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_acrej')));
        }
    }

    public function setAcrejAllowed(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getAcrejAllowed() === null) {
            $model->setAcrejAllowed(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_acrej_allowed')));
        }
    }

    public function setClirovr(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getClirovr() === null) {
            $model->setClirovr(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_clirovr')));
        }
    }

    public function setDnd(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getDnd() === null) {
            $model->setDnd(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_dnd')));
        }
    }

    public function setDndAllowed(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getDndAllowed() === null) {
            $model->setDndAllowed(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_dnd_allowed')));
        }
    }

    public function setHotline(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getHotline() === null) {
            $model->setHotline(ConfigHelper::getConfig('adescom.default_clid_hotline'));
        }
    }

    public function setHotlineAllowed(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getHotlineAllowed() === null) {
            $model->setHotlineAllowed(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_hotline_allowed')));
        }
    }

    public function setCw(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getCw() === null) {
            $model->setCw(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_cw')));
        }
    }

    public function setCwAllowed(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getCwAllowed() === null) {
            $model->setCwAllowed(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_cw_allowed')));
        }
    }

    public function setNway(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getNway() === null) {
            $model->setNway(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_nway')));
        }
    }

    public function setAlarm(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getAlarm() === null) {
            $model->setAlarm(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_alarm')));
        }
    }

    public function setForwarding(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getForwarding() === null) {
            $model->setForwarding(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_forwarding')));
        }
    }

    public function setCfu(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getCfu() === null) {
            $model->setCfu(ConfigHelper::getConfig('adescom.default_clid_cfu'));
        }
    }

    public function setCfb(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getCfb() === null) {
            $model->setCfb(ConfigHelper::getConfig('adescom.default_clid_cfb'));
        }
    }

    public function setCfnr(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getCfnr() === null) {
            $model->setCfnr(ConfigHelper::getConfig('adescom.default_clid_cfnr'));
        }
    }

    public function setCfur(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getCfur() === null) {
            $model->setCfur(ConfigHelper::getConfig('adescom.default_clid_cfur'));
        }
    }

    public function setF2m(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getF2m() === null) {
            $model->setF2m(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_f2m')));
        }
    }

    public function setUf2m(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getUf2m() === null) {
            $model->setUf2m(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_uf2m')));
        }
    }

    public function setNrf2m(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getNrf2m() === null) {
            $model->setNrf2m(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_nrf2m')));
        }
    }

    public function setBlindXfer(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getBlindXfer() === null) {
            $model->setBlindXfer(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_blind_xfer')));
        }
    }

    public function setAtXfer(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getAtXfer() === null) {
            $model->setAtXfer(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_at_xfer')));
        }
    }

    public function setOcbAllowed(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getOcbAllowed() === null) {
            $model->setOcbAllowed(ConfigHelper::checkValue(ConfigHelper::getConfig('adescom.default_clid_ocb_allowed')));
        }
    }

    public function setOcb(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getOcb() === null) {
            $model->setOcb(ConfigHelper::getConfig('adescom.default_clid_ocb'));
        }
    }

    public function setOcbPassword(ClidServices $model, $force = false)
    {
        if ($force === true || $model->getOcbPassword() === null) {
            $model->setOcbPassword(ConfigHelper::getConfig('adescom.default_clid_ocb_password'));
        }
    }
    
}
