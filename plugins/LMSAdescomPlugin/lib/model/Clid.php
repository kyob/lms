<?php

/**
 * Clid
 *
 * @package 
 * @author Maciej Lew <maciej.lew@adescom.pl>
 */
class Clid extends VoIPAccount
{

    const PROPERTY_COUNTRY_CODE = 'countrycode';
    const PROPERTY_AREA_CODE = 'areacode';
    const PROPERTY_SHORT_CLID = 'shortclid';
    const PROPERTY_REGISTRATION_CLID = 'registration_type';
    const PROPERTY_PORTED = 'ported';
    const PROPERTY_AUTO_ACTIVATION_DATE = 'autoactivation_date';
    const PROPERTY_CTM_ID = 'ctmid';
    const PROPERTY_PHONE_ID = 'phoneid';
    const PROPERTY_LINE = 'line';
    const PROPERTY_CONTEXT = 'context';
    const PROPERTY_HOST = 'host';
    const PROPERTY_MAC_ADDRESS = 'mac_address';
    const PROPERTY_PREPAID_STATE = 'prepaid_state';
    const PROPERTY_ABSOLUTE_COST_LIMIT = 'absolute_cost_limit';
    const PROPERTY_EMERGENCY_CONTEXT = 'emergencycontext';
    const PROPERTY_TARIFF_ID = 'tariffid';
    const PROPERTY_IS_PREPAID = 'is_prepaid';
    const PROPERTY_POOL_ID = 'poolid';
    const PROPERTY_DISPLAY_NAME = 'displayname';
    const PROPERTY_PHONE_LINE = 'phone_line';
    const PROPERTY_EMAIL = 'email';
    const PROPERTY_HOST_NAME = 'hostname';
    const PROPERTY_SERIAL_NUMBER = 'serial_number';
    const PROPERTY_VOICE_MAIL = 'voicemail';
    const PROPERTY_VOICE_MAIL_PASSWORD = 'voicemailpassword';
    const PROPERTY_VOICE_MAIL_ATTACHMENT = 'voicemailattach';
    

    protected $countryCode;
    protected $areaCode;
    protected $shortClid;
    protected $registrationType;
    protected $ported;
    protected $autoactivationDate;
    protected $ctmId;
    protected $phoneId;
    protected $line;
    protected $context;
    protected $host;
    protected $macAddress;
    protected $prepaidState;
    protected $absoluteCostLimit;
    protected $emergencyContext;
    protected $tariffId;
    protected $isPrepaid;
    protected $poolId;
    protected $displayName;
    protected $phoneLine;
    protected $email;
    protected $hostName;
    protected $serialNumber;
    protected $voiceMail;
    protected $voiceMailPassword;
    protected $voiceMailAttachment;
    
    /** @var ClidServicesWrapper Clid services */
    protected $clidServices;
    
    /**
     * Constructs clid
     * 
     * Adds clid services wrapper
     */
    public function __construct()
    {
        $this->clidServices = new ClidServicesWrapper();
    }
    
    /**
     * Fills model from array
     * 
     * @param array $model Model
     */
    public function fromArray(array $model)
    {
        parent::fromArray($model);
        
        if (isset($model[self::PROPERTY_COUNTRY_CODE])) {
            $this->countryCode = $model[self::PROPERTY_COUNTRY_CODE];
        }
        if (isset($model[self::PROPERTY_AREA_CODE])) {
            $this->areaCode = $model[self::PROPERTY_AREA_CODE];
        }
        if (isset($model[self::PROPERTY_SHORT_CLID])) {
            $this->shortClid = $model[self::PROPERTY_SHORT_CLID];
        }
        if (isset($model[self::PROPERTY_REGISTRATION_CLID])) {
            $this->registrationType = $model[self::PROPERTY_REGISTRATION_CLID];
        }
        if (isset($model[self::PROPERTY_PORTED])) {
            $this->ported = $model[self::PROPERTY_PORTED];
        }
        if (isset($model[self::PROPERTY_AUTO_ACTIVATION_DATE])) {
            $time = strtotime($model[self::PROPERTY_AUTO_ACTIVATION_DATE]);
            $date = date('Y-m-d', $time);
            $this->autoactivationDate = $date;
        }
        if (isset($model[self::PROPERTY_CTM_ID])) {
            $this->ctmId = $model[self::PROPERTY_CTM_ID];
        }
        if (isset($model[self::PROPERTY_PHONE_ID])) {
            $this->phoneId = $model[self::PROPERTY_PHONE_ID];
        }
        if (isset($model[self::PROPERTY_LINE])) {
            $this->line = $model[self::PROPERTY_LINE];
        }
        if (isset($model[self::PROPERTY_CONTEXT])) {
            $this->context = $model[self::PROPERTY_CONTEXT];
        }
        if (isset($model[self::PROPERTY_HOST])) {
            $this->host = $model[self::PROPERTY_HOST];
        }
        if (isset($model[self::PROPERTY_MAC_ADDRESS])) {
            $this->macAddress = $model[self::PROPERTY_MAC_ADDRESS];
        }
        if (isset($model[self::PROPERTY_PREPAID_STATE])) {
            $this->prepaidState = str_replace(',', '.', $model[self::PROPERTY_PREPAID_STATE]);
        }
        if (isset($model[self::PROPERTY_ABSOLUTE_COST_LIMIT])) {
            $this->absoluteCostLimit = $model[self::PROPERTY_ABSOLUTE_COST_LIMIT];
        }
        if (isset($model[self::PROPERTY_EMERGENCY_CONTEXT])) {
            $this->emergencyContext = $model[self::PROPERTY_EMERGENCY_CONTEXT];
        }
        if (isset($model[self::PROPERTY_TARIFF_ID])) {
            $this->tariffId = $model[self::PROPERTY_TARIFF_ID];
        }
        if (isset($model[self::PROPERTY_IS_PREPAID])) {
            $this->isPrepaid = $model[self::PROPERTY_IS_PREPAID];
        }
        
        if (isset($model[self::PROPERTY_POOL_ID])) {
            $this->poolId = $model[self::PROPERTY_POOL_ID];
        }
        if (isset($model[self::PROPERTY_DISPLAY_NAME])) {
            $this->displayName = $model[self::PROPERTY_DISPLAY_NAME];
        }
        if (isset($model[self::PROPERTY_PHONE_LINE])) {
            $this->phoneLine = $model[self::PROPERTY_PHONE_LINE];
        }
        if (isset($model[self::PROPERTY_EMAIL])) {
            $this->email = $model[self::PROPERTY_EMAIL];
        }
        if (isset($model[self::PROPERTY_HOST_NAME])) {
            $this->hostName = $model[self::PROPERTY_HOST_NAME];
        }
        if (isset($model[self::PROPERTY_SERIAL_NUMBER])) {
            $this->serialNumber = $model[self::PROPERTY_SERIAL_NUMBER];
        }
        if (isset($model[self::PROPERTY_VOICE_MAIL])) {
            $this->voiceMail = $model[self::PROPERTY_VOICE_MAIL];
        }
        if (isset($model[self::PROPERTY_VOICE_MAIL_PASSWORD])) {
            $this->voiceMailPassword = $model[self::PROPERTY_VOICE_MAIL_PASSWORD];
        }
        if (isset($model[self::PROPERTY_VOICE_MAIL_ATTACHMENT])) {
            $this->voiceMailAttachment = $model[self::PROPERTY_VOICE_MAIL_ATTACHMENT];
        }
        
        if ($this->clidServices !== null) {
            $this->clidServices->fromArray($model);
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
        $model = array_merge($model, parent::toArray($model));
        
        $model[self::PROPERTY_COUNTRY_CODE] = $this->countryCode;
        $model[self::PROPERTY_AREA_CODE] = $this->areaCode;
        $model[self::PROPERTY_SHORT_CLID] = $this->shortClid;
        $model[self::PROPERTY_REGISTRATION_CLID] = $this->registrationType;
        $model[self::PROPERTY_PORTED] = $this->ported;
        $model[self::PROPERTY_AUTO_ACTIVATION_DATE] = $this->autoactivationDate;
        $model[self::PROPERTY_CTM_ID] = $this->ctmId;
        $model[self::PROPERTY_PHONE_ID] = $this->phoneId;
        $model[self::PROPERTY_LINE] = $this->line;
        $model[self::PROPERTY_CONTEXT] = $this->context;
        $model[self::PROPERTY_HOST] = $this->host;
        $model[self::PROPERTY_MAC_ADDRESS] = $this->macAddress;
        $model[self::PROPERTY_PREPAID_STATE] = $this->prepaidState;
        $model[self::PROPERTY_ABSOLUTE_COST_LIMIT] = $this->absoluteCostLimit;
        $model[self::PROPERTY_EMERGENCY_CONTEXT] = $this->emergencyContext;
        $model[self::PROPERTY_TARIFF_ID] = $this->tariffId;
        $model[self::PROPERTY_IS_PREPAID] = $this->isPrepaid;
        
        $model[self::PROPERTY_POOL_ID] = $this->poolId;
        $model[self::PROPERTY_DISPLAY_NAME] = $this->displayName;
        $model[self::PROPERTY_PHONE_LINE] = $this->phoneLine;
        $model[self::PROPERTY_EMAIL] = $this->email;
        $model[self::PROPERTY_HOST_NAME] = $this->hostName;
        $model[self::PROPERTY_SERIAL_NUMBER] = $this->serialNumber;
        $model[self::PROPERTY_VOICE_MAIL] = $this->voiceMail;
        $model[self::PROPERTY_VOICE_MAIL_PASSWORD] = $this->voiceMailPassword;
        $model[self::PROPERTY_VOICE_MAIL_ATTACHMENT] = $this->voiceMailAttachment;
        
        if ($this->clidServices !== null) {
            $model = array_merge($model, $this->clidServices->toArray($model));
        }
        
        return $model;
    }
    
    /**
     * Prepares login
     */
    public function prepareLogin()
    {
        switch ($this->registrationType) {
            case RegistrationType::COUNTRY_AREA_LOCAL:
                $this->login = $this->countryCode . $this->areaCode . $this->shortClid;
                break;
            case RegistrationType::AREA_LOCAL:
                $this->login = $this->areaCode . $this->shortClid;
                break;
            case RegistrationType::LOCAL:
                $this->login = $this->shortClid;
                break;
            default:
                $this->login = $this->areaCode . $this->shortClid;
                break;
        }
    }
    
    /**
     * Prepares phone
     */
    public function preparePhone()
    {
        $this->phone = $this->countryCode . $this->areaCode . $this->shortClid;
    }

    public function getClidServices()
    {
        return $this->clidServices;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPasswd()
    {
        return $this->passwd;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public function getAreaCode()
    {
        return $this->areaCode;
    }

    public function getShortClid()
    {
        return $this->shortClid;
    }

    public function getRegistrationType()
    {
        return $this->registrationType;
    }

    public function getPorted()
    {
        return $this->ported;
    }

    public function getAutoactivationDate()
    {
        return $this->autoactivationDate;
    }

    public function getCtmId()
    {
        return $this->ctmId;
    }

    public function getPhoneId()
    {
        return $this->phoneId;
    }

    public function getLine()
    {
        return $this->line;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getMacAddress()
    {
        return $this->macAddress;
    }

    public function getPrepaidState()
    {
        return $this->prepaidState;
    }

    public function getAbsoluteCostLimit()
    {
        return $this->absoluteCostLimit;
    }

    public function getEmergencyContext()
    {
        return $this->emergencyContext;
    }

    public function getTariffId()
    {
        return $this->tariffId;
    }

    public function getIsPrepaid()
    {
        return $this->isPrepaid;
    }

    public function getPoolId()
    {
        return $this->poolId;
    }
    
    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function getPhoneLine()
    {
        return $this->phoneLine;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getHostName()
    {
        return $this->hostName;
    }

    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    public function getVoiceMail()
    {
        return $this->voiceMail;
    }

    public function getVoiceMailPassword()
    {
        return $this->voiceMailPassword;
    }

    public function getVoiceMailAttachment()
    {
        return $this->voiceMailAttachment;
    }
    
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    public function setAreaCode($areaCode)
    {
        $this->areaCode = $areaCode;
    }

    public function setShortClid($shortClid)
    {
        $this->shortClid = $shortClid;
    }

    public function setRegistrationType($registrationType)
    {
        $this->registrationType = $registrationType;
    }

    public function setPorted($ported)
    {
        $this->ported = $ported;
    }

    public function setAutoactivationDate($autoactivationDate)
    {
        $time = strtotime($autoactivationDate);
        $date = date('Y-m-d', $time);
        $this->autoactivationDate = $date;
    }

    public function setCtmId($ctmId)
    {
        $this->ctmId = $ctmId;
    }

    public function setPhoneId($phoneId)
    {
        $this->phoneId = $phoneId;
    }

    public function setLine($line)
    {
        $this->line = $line;
    }

    public function setContext($context)
    {
        $this->context = $context;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function setMacAddress($macAddress)
    {
        $this->macAddress = $macAddress;
    }

    public function setPrepaidState($prepaidState)
    {
        $this->prepaidState = $prepaidState;
    }

    public function setAbsoluteCostLimit($absoluteCostLimit)
    {
        $this->absoluteCostLimit = $absoluteCostLimit;
    }

    public function setEmergencyContext($emergencyContext)
    {
        $this->emergencyContext = $emergencyContext;
    }

    public function setTariffId($tariffId)
    {
        $this->tariffId = $tariffId;
    }

    public function setIsPrepaid($isPrepaid)
    {
        $this->isPrepaid = $isPrepaid;
    }

    public function setPoolId($poolId)
    {
        $this->poolId = $poolId;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    public function setPhoneLine($phoneLine)
    {
        $this->phoneLine = $phoneLine;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setHostName($hostName)
    {
        $this->hostName = $hostName;
    }

    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;
    }

    public function setVoiceMail($voiceMail)
    {
        $this->voiceMail = $voiceMail;
    }

    public function setVoiceMailPassword($voiceMailPassword)
    {
        $this->voiceMailPassword = $voiceMailPassword;
    }

    public function setVoiceMailAttachment($voiceMailAttachment)
    {
        $this->voiceMailAttachment = $voiceMailAttachment;
    }


    
}
