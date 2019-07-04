<?php

namespace Rapidmail\Oxid6Module\Controller;

use OxidEsales\Eshop\Core\Request;
use Rapidmail\Oxid6Module\Helper\DatabaseHelper;
use Rapidmail\Oxid6Module\Model\CustomerModel;
use Rapidmail\Oxid6Module\Response\ListResponse;

/**
 * CustomerController
 */
class CustomerController extends BaseController
{

    /**
     * @inheritDoc
     */
    public function init()
    {

        parent::init();

        $this->buildResponse(function (Request $request) {

            /** @var CustomerModel $customerModel */
            $customerModel = oxNew(
                CustomerModel::class,
                DatabaseHelper::getDatabaseAdapter(),
                DatabaseHelper::getQueryBuilderFactory()
            );

            return oxNew(
                ListResponse::class,
                $request,
                $customerModel
            );

        });

    }

}