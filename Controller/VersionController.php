<?php

namespace Rapidmail\Oxid6Module\Controller;

use OxidEsales\Eshop\Core\Request;
use Rapidmail\Oxid6Module\Helper\DatabaseHelper;
use Rapidmail\Oxid6Module\Model\VersionModel;
use Rapidmail\Oxid6Module\Response\ListResponse;

/**
 * VersionController
 */
class VersionController extends BaseController
{

    /**
     * @inheritDoc
     */
    public function init()
    {

        parent::init();

        $this->buildResponse(function (Request $request) {

            /** @var VersionModel $versionModel */
            $versionModel = oxNew(
                VersionModel::class,
                DatabaseHelper::getDatabaseAdapter(),
                DatabaseHelper::getQueryBuilderFactory()
            );

            return oxNew(
                ListResponse::class,
                $request,
                $versionModel
            );

        });

    }

}