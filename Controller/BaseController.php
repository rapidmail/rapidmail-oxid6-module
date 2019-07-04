<?php

namespace Rapidmail\Oxid6Module\Controller;

use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use Rapidmail\Oxid6Module\Helper\AuthenticationHelper;

/**
 * BaseController
 */
class BaseController extends FrontendController
{

    /**
     * @var string[]
     */
    protected $_aAllowedMethods = [
        'GET'
    ];

    /**
     * @inheritDoc
     */
    public function init()
    {

        if (!in_array($_SERVER['REQUEST_METHOD'], $this->_aAllowedMethods)) {
            $this->sendResponse(405, 'Method not allowed');
        }

        /** @var User $user */
        $user = oxNew(User::class);
        $authHelper = new AuthenticationHelper(Registry::getUtilsServer());

        if (!$authHelper->authenticate($user)) {
            $this->sendResponse(401, 'User authentication failed');
        }

        parent::init();

    }

    /**
     * @param callable $callable
     */
    protected function buildResponse(callable $callable)
    {

        try {

            /** @var \OxidEsales\Eshop\Core\Request $request */
            $request = oxNew(Request::class);

            /** @var \Rapidmail\Oxid6Module\Response\ResponseInterface $result */
            $result = $callable($request);

            $statusCode = $result->getStatusCode();
            $encodedResponse = json_encode($result);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $statusCode = 500;
                $encodedResponse = 'Problem during json encoding';
            }

            $this->sendResponse($statusCode, $encodedResponse);

        } catch (\Exception $e) {
            $this->sendResponse(500, $e->getMessage());
        }

    }

    /**
     * @param int $code
     * @param mixed $msg
     */
    protected function sendResponse($code, $msg = null)
    {
        header('Content-Type: application/json;', true, $code);
        Registry::getUtils()->showMessageAndExit($msg);

    }

}