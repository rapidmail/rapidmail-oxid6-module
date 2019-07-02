<?php

namespace Rapidmail\Oxid6Module\Controller;

use OxidEsales\Eshop\Core\Request;
use OxidEsales\Facts\Edition\EditionSelector;
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
                new EditionSelector()
            );

            return oxNew(
                ListResponse::class,
                $request,
                $versionModel
            );

        });

    }

}