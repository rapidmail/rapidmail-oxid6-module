<?php

namespace Rapidmail\Oxid6Module\Helper;

use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Exception\UserException;
use OxidEsales\Eshop\Core\UtilsServer;

class AuthenticationHelper
{

    /**
     * @var UtilsServer
     */
    private $_oUtilsServer;

    /**
     * Array of allowed user groups
     *
     * @var string[]
     */
    private $_aAuthGroups = [
        'oxjsonro', // Oxid json read only group, use old name for compatibility
        'rmoxconnect'
    ];

    /**
     * Constructor
     *
     * @param UtilsServer $_oUtilsServer
     */
    public function __construct(UtilsServer $_oUtilsServer)
    {
        $this->_oUtilsServer = $_oUtilsServer;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function authenticate(User $user)
    {

        list($email, $password) = explode(':', $this->extractAuthenticationHeader($this->_oUtilsServer));

        try {

            if (!$user->login($email, $password)) {
                return false;
            }

        } catch (UserException $e) {
            return false;
        };

        return $this->isAuthorized($user);

    }

    /**
     * @param UtilsServer $utilsServer
     * @return string
     */
    protected function extractAuthenticationHeader(UtilsServer $utilsServer)
    {

        $authHeader = $utilsServer->getServerVar('HTTP_AUTHORIZATION');

        if (empty($authHeader)) {
            $authHeader = $utilsServer->getServerVar('REDIRECT_HTTP_AUTHORIZATION');
        }

        if (0 === strpos($authHeader, 'Ox')) {
            $authHeader = substr($authHeader, 2);
        }

        if (0 === strpos($authHeader, 'Basic ')) {
            $authHeader = substr($authHeader, 6);
        }

        return base64_decode($authHeader);

    }

    /**
     * @param User $user
     * @return bool
     */
    public function isAuthorized(User $user = null)
    {

        if (empty($user)) {
            return false;
        }

        foreach ($this->_aAuthGroups as $authGroup) {

            if ($user->inGroup($authGroup)) {
                return true;
            }

        }

        return false;

    }

}