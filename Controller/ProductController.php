<?php

namespace Rapidmail\Oxid6Module\Controller;

use OxidEsales\Eshop\Core\Request;
use Rapidmail\Oxid6Module\Helper\DatabaseHelper;
use Rapidmail\Oxid6Module\Model\ProductModel;
use Rapidmail\Oxid6Module\Response\ListResponse;

/**
 * ProductController
 */
class ProductController extends BaseController
{

    /**
     * @inheritDoc
     */
    public function init()
    {

        parent::init();

        $this->buildResponse(function (Request $request) {

            /** @var ProductModel $productModel */
            $productModel = oxNew(
                ProductModel::class,
                DatabaseHelper::getDatabaseAdapter(),
                DatabaseHelper::getQueryBuilderFactory()
            );

            return oxNew(
                ListResponse::class,
                $request,
                $productModel
            );

        });

    }

}