<?php

/**
 * AdescomUserpanelManager
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class AdescomUserpanelManager
{
    /**
     * Returns userpanel external name
     * 
     * @param int $client_id Client id
     * @param AdescomSoapClient $connection Connection
     * @return stdClass Response
     */
    public function userpanelGetExternalUserName($client_id, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }
        return $connection->userpanelGetExternalUserName($client_id);
    }

    /**
     * Login to userpanel
     * 
     * @param string $username Username
     * @param string $security_template Security template
     * @param AdescomSoapClient $connection Connection
     * @return stdClass Response
     */
    public function userpanelExternalLogin($username, $security_template = 'superuser', AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $global_password = ConfigHelper::getConfig('adescom.userpanel_global_password');
        $challenge_salt = ConfigHelper::getConfig('adescom.userpanel_challenge_salt');

        $response = $connection->userpanelExternalLogin($global_password, $username, $security_template);
        $response->challengeHash = sha1($response->challenge . $challenge_salt);
        return $response;
    }
}
