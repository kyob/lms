<?php

/**
 * VoIPAccount
 *
 * @package 
 * @author Maciej Lew <maciej.lew@adescom.pl>
 */
class VoIPAccount extends AdescomModel
{
    const PROPERTY_ID = 'id';
    const PROPERTY_OWNER_ID = 'ownerid';
    const PROPERTY_LOGIN = 'login';
    const PROPERTY_PASSWD = 'passwd';
    const PROPERTY_PHONE = 'phone';
    const PROPERTY_ACTIVE = 'active';
    
    protected $id;
    protected $ownerId;
    protected $login;
    protected $passwd;
    protected $phone;
    protected $active;
    
    /**
     * Fills model from array
     * 
     * @param array $model Model
     */
    public function fromArray(array $model)
    {
        if (isset($model[self::PROPERTY_ID])) {
            $this->id = $model[self::PROPERTY_ID];
        }
        if (isset($model[self::PROPERTY_OWNER_ID])) {
            $this->ownerId = $model[self::PROPERTY_OWNER_ID];
        }
        if (isset($model[self::PROPERTY_LOGIN])) {
            $this->login = $model[self::PROPERTY_LOGIN];
        }
        if (isset($model[self::PROPERTY_PASSWD])) {
            $this->passwd = $model[self::PROPERTY_PASSWD];
        }
        if (isset($model[self::PROPERTY_PHONE])) {
            $this->phone = $model[self::PROPERTY_PHONE];
        }
        if (isset($model[self::PROPERTY_ACTIVE])) {
            $this->active = $model[self::PROPERTY_ACTIVE];
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
        $model[self::PROPERTY_ID] = $this->id;
        $model[self::PROPERTY_OWNER_ID] = $this->ownerId;
        $model[self::PROPERTY_LOGIN] = $this->login;
        $model[self::PROPERTY_PASSWD] = $this->passwd;
        $model[self::PROPERTY_PHONE] = $this->phone;
        $model[self::PROPERTY_ACTIVE] = $this->active;
        return $model;
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
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }


    
}
