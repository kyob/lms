<?php

/**
 * VoIPAccountServices
 *
 * @package 
 * @author Maciej Lew <maciej.lew@adescom.pl>
 */
class ClidServices extends AdescomModel
{
    const PROPERTY_CLIP = 'clip';
    const PROPERTY_CLIR = 'clir';
    const PROPERTY_CLIR_ALLOWED = 'clir_allowed';
    const PROPERTY_ACREJ = 'acrej';
    const PROPERTY_ACREJ_ALLOWED = 'acrej_allowed';
    const PROPERTY_CLIROVR = 'clirovr';
    const PROPERTY_DND = 'dnd';
    const PROPERTY_DND_ALLOWED = 'dnd_allowed';
    const PROPERTY_HOTLINE = 'hotline';
    const PROPERTY_HOTLINE_ALLOWED = 'hotline_allowed';
    const PROPERTY_CW = 'cw';
    const PROPERTY_CW_ALLOWED = 'cw_allowed';
    const PROPERTY_NWAY = 'nway';
    const PROPERTY_ALARM = 'alarm';
    const PROPERTY_FORWARDING = 'forwarding';
    const PROPERTY_CFU = 'cfu';
    const PROPERTY_CFB = 'cfb';
    const PROPERTY_CFNR = 'cfnr';
    const PROPERTY_CFUR = 'cfur';
    const PROPERTY_F2M = 'f2m';
    const PROPERTY_UF2M = 'uf2m';
    const PROPERTY_NRF2M = 'nrf2m';
    const PROPERTY_BLIND_XFER = 'blind_xfer';
    const PROPERTY_AT_XFER = 'at_xfer';
    const PROPERTY_OCB_ALLOWED = 'ocb_allowed';
    const PROPERTY_OCB = 'ocb';
    const PROPERTY_OCB_PASSWORD = 'ocb_password';
    
    protected $clip;
    protected $clir;
    protected $clirAllowed;
    protected $acrej;
    protected $acrejAllowed;
    protected $clirovr;
    protected $dnd;
    protected $dndAllowed;
    protected $hotline;
    protected $hotlineAllowed;
    protected $cw;
    protected $cwAllowed;
    protected $nway;
    protected $alarm;
    protected $forwarding;
    protected $cfu;
    protected $cfb;
    protected $cfnr;
    protected $cfur;
    protected $f2m;
    protected $uf2m;
    protected $nrf2m;
    protected $blindXfer;
    protected $atXfer;
    protected $ocbAllowed;
    protected $ocb;
    protected $ocbPassword;
    
    /**
     * Fills model from array
     * 
     * @param array $model Model
     */
    public function fromArray(array $model)
    {
        if (isset($model[self::PROPERTY_CLIP])) {
            $this->clip = $model[self::PROPERTY_CLIP];
        }
        if (isset($model[self::PROPERTY_CLIR])) {
            $this->clir = $model[self::PROPERTY_CLIR];
        }
        if (isset($model[self::PROPERTY_CLIR_ALLOWED])) {
            $this->clirAllowed = $model[self::PROPERTY_CLIR_ALLOWED];
        }
        if (isset($model[self::PROPERTY_ACREJ])) {
            $this->acrej = $model[self::PROPERTY_ACREJ];
        }
        if (isset($model[self::PROPERTY_ACREJ_ALLOWED])) {
            $this->acrejAllowed = $model[self::PROPERTY_ACREJ_ALLOWED];
        }
        if (isset($model[self::PROPERTY_CLIROVR])) {
            $this->clirovr = $model[self::PROPERTY_CLIROVR];
        }
        if (isset($model[self::PROPERTY_DND])) {
            $this->dnd = $model[self::PROPERTY_DND];
        }
        if (isset($model[self::PROPERTY_DND_ALLOWED])) {
            $this->dndAllowed = $model[self::PROPERTY_DND_ALLOWED];
        }
        if (isset($model[self::PROPERTY_HOTLINE])) {
            $this->hotline = $model[self::PROPERTY_HOTLINE];
        }
        if (isset($model[self::PROPERTY_HOTLINE_ALLOWED])) {
            $this->hotlineAllowed = $model[self::PROPERTY_HOTLINE_ALLOWED];
        }
        if (isset($model[self::PROPERTY_CW])) {
            $this->cw = $model[self::PROPERTY_CW];
        }
        if (isset($model[self::PROPERTY_CW_ALLOWED])) {
            $this->cwAllowed = $model[self::PROPERTY_CW_ALLOWED];
        }
        if (isset($model[self::PROPERTY_NWAY])) {
            $this->nway = $model[self::PROPERTY_NWAY];
        }
        if (isset($model[self::PROPERTY_ALARM])) {
            $this->alarm = $model[self::PROPERTY_ALARM];
        }
        if (isset($model[self::PROPERTY_FORWARDING])) {
            $this->forwarding = $model[self::PROPERTY_FORWARDING];
        }
        if (isset($model[self::PROPERTY_CFU])) {
            $this->cfu = $model[self::PROPERTY_CFU];
        }
        if (isset($model[self::PROPERTY_CFB])) {
            $this->cfb = $model[self::PROPERTY_CFB];
        }
        if (isset($model[self::PROPERTY_CFNR])) {
            $this->cfnr = $model[self::PROPERTY_CFNR];
        }
        if (isset($model[self::PROPERTY_CFUR])) {
            $this->cfur = $model[self::PROPERTY_CFUR];
        }
        if (isset($model[self::PROPERTY_F2M])) {
            $this->f2m = $model[self::PROPERTY_F2M];
        }
        if (isset($model[self::PROPERTY_UF2M])) {
            $this->uf2m = $model[self::PROPERTY_UF2M];
        }
        if (isset($model[self::PROPERTY_NRF2M])) {
            $this->nrf2m = $model[self::PROPERTY_NRF2M];
        }
        if (isset($model[self::PROPERTY_BLIND_XFER])) {
            $this->blindXfer = $model[self::PROPERTY_BLIND_XFER];
        }
        if (isset($model[self::PROPERTY_AT_XFER])) {
            $this->atXfer = $model[self::PROPERTY_AT_XFER];
        }
        if (isset($model[self::PROPERTY_OCB_ALLOWED])) {
            $this->ocbAllowed = $model[self::PROPERTY_OCB_ALLOWED];
        }
        if (isset($model[self::PROPERTY_OCB])) {
            $this->ocb = $model[self::PROPERTY_OCB];
        }
        if (isset($model[self::PROPERTY_OCB_PASSWORD])) {
            $this->ocbPassword = $model[self::PROPERTY_OCB_PASSWORD];
        }
    }

    /**
     * Converts model to array
     * 
     * @param array $model Model
     * @return array Model
     */
    public function toArray(array $model = array())
    {
        $model[self::PROPERTY_CLIP] = $this->clip;
        $model[self::PROPERTY_CLIR] = $this->clir;
        $model[self::PROPERTY_CLIR_ALLOWED] = $this->clirAllowed;
        $model[self::PROPERTY_ACREJ] = $this->acrej;
        $model[self::PROPERTY_ACREJ_ALLOWED] = $this->acrejAllowed;
        $model[self::PROPERTY_CLIROVR] = $this->clirovr;
        $model[self::PROPERTY_DND] = $this->dnd;
        $model[self::PROPERTY_DND_ALLOWED] = $this->dndAllowed;
        $model[self::PROPERTY_HOTLINE] = $this->hotline;
        $model[self::PROPERTY_HOTLINE_ALLOWED] = $this->hotlineAllowed;
        $model[self::PROPERTY_CW] = $this->cw;
        $model[self::PROPERTY_CW_ALLOWED] = $this->cwAllowed;
        $model[self::PROPERTY_NWAY] = $this->nway;
        $model[self::PROPERTY_ALARM] = $this->alarm;
        $model[self::PROPERTY_FORWARDING] = $this->forwarding;
        $model[self::PROPERTY_CFU] = $this->cfu;
        $model[self::PROPERTY_CFB] = $this->cfb;
        $model[self::PROPERTY_CFNR] = $this->cfnr;
        $model[self::PROPERTY_CFUR] = $this->cfur;
        $model[self::PROPERTY_F2M] = $this->f2m;
        $model[self::PROPERTY_UF2M] = $this->uf2m;
        $model[self::PROPERTY_NRF2M] = $this->nrf2m;
        $model[self::PROPERTY_BLIND_XFER] = $this->blindXfer;
        $model[self::PROPERTY_AT_XFER] = $this->atXfer;
        $model[self::PROPERTY_OCB_ALLOWED] = $this->ocbAllowed;
        $model[self::PROPERTY_OCB] = $this->ocb;
        $model[self::PROPERTY_OCB_PASSWORD] = $this->ocbPassword;
        return $model;
    }
    
    public function getClip()
    {
        return $this->clip;
    }

    public function getClir()
    {
        return $this->clir;
    }

    public function getClirAllowed()
    {
        return $this->clirAllowed;
    }

    public function getAcrej()
    {
        return $this->acrej;
    }

    public function getAcrejAllowed()
    {
        return $this->acrejAllowed;
    }

    public function getClirovr()
    {
        return $this->clirovr;
    }

    public function getDnd()
    {
        return $this->dnd;
    }

    public function getDndAllowed()
    {
        return $this->dndAllowed;
    }

    public function getHotline()
    {
        return $this->hotline;
    }

    public function getHotlineAllowed()
    {
        return $this->hotlineAllowed;
    }

    public function getCw()
    {
        return $this->cw;
    }

    public function getCwAllowed()
    {
        return $this->cwAllowed;
    }

    public function getNway()
    {
        return $this->nway;
    }

    public function getAlarm()
    {
        return $this->alarm;
    }

    public function getForwarding()
    {
        return $this->forwarding;
    }

    public function getCfu()
    {
        return $this->cfu;
    }

    public function getCfb()
    {
        return $this->cfb;
    }

    public function getCfnr()
    {
        return $this->cfnr;
    }

    public function getCfur()
    {
        return $this->cfur;
    }

    public function getF2m()
    {
        return $this->f2m;
    }

    public function getUf2m()
    {
        return $this->uf2m;
    }

    public function getNrf2m()
    {
        return $this->nrf2m;
    }

    public function getBlindXfer()
    {
        return $this->blindXfer;
    }

    public function getAtXfer()
    {
        return $this->atXfer;
    }

    public function getOcbAllowed()
    {
        return $this->ocbAllowed;
    }

    public function getOcb()
    {
        return $this->ocb;
    }

    public function getOcbPassword()
    {
        return $this->ocbPassword;
    }

    public function setClip($clip)
    {
        $this->clip = $clip;
    }

    public function setClir($clir)
    {
        $this->clir = $clir;
    }

    public function setClirAllowed($clirAllowed)
    {
        $this->clirAllowed = $clirAllowed;
    }

    public function setAcrej($acrej)
    {
        $this->acrej = $acrej;
    }

    public function setAcrejAllowed($acrejAllowed)
    {
        $this->acrejAllowed = $acrejAllowed;
    }

    public function setClirovr($clirovr)
    {
        $this->clirovr = $clirovr;
    }

    public function setDnd($dnd)
    {
        $this->dnd = $dnd;
    }

    public function setDndAllowed($dndAllowed)
    {
        $this->dndAllowed = $dndAllowed;
    }

    public function setHotline($hotline)
    {
        $this->hotline = $hotline;
    }

    public function setHotlineAllowed($hotlineAllowed)
    {
        $this->hotlineAllowed = $hotlineAllowed;
    }

    public function setCw($cw)
    {
        $this->cw = $cw;
    }

    public function setCwAllowed($cwAllowed)
    {
        $this->cwAllowed = $cwAllowed;
    }

    public function setNway($nway)
    {
        $this->nway = $nway;
    }

    public function setAlarm($alarm)
    {
        $this->alarm = $alarm;
    }

    public function setForwarding($forwarding)
    {
        $this->forwarding = $forwarding;
    }

    public function setCfu($cfu)
    {
        $this->cfu = $cfu;
    }

    public function setCfb($cfb)
    {
        $this->cfb = $cfb;
    }

    public function setCfnr($cfnr)
    {
        $this->cfnr = $cfnr;
    }

    public function setCfur($cfur)
    {
        $this->cfur = $cfur;
    }

    public function setF2m($f2m)
    {
        $this->f2m = $f2m;
    }

    public function setUf2m($uf2m)
    {
        $this->uf2m = $uf2m;
    }

    public function setNrf2m($nrf2m)
    {
        $this->nrf2m = $nrf2m;
    }

    public function setBlindXfer($blindXfer)
    {
        $this->blindXfer = $blindXfer;
    }

    public function setAtXfer($atXfer)
    {
        $this->atXfer = $atXfer;
    }

    public function setOcbAllowed($ocbAllowed)
    {
        $this->ocbAllowed = $ocbAllowed;
    }

    public function setOcb($ocb)
    {
        $this->ocb = $ocb;
    }

    public function setOcbPassword($ocbPassword)
    {
        $this->ocbPassword = $ocbPassword;
    }



}
