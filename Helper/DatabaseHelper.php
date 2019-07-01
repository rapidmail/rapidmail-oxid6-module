<?php

namespace Rapidmail\Oxid6Module\Helper;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Common\Database\QueryBuilderFactoryInterface;

/**
 * DatabaseHelper
 */
class DatabaseHelper
{

    /**
     * @return \OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    public static function getDatabaseAdapter()
    {
        return DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);
    }

    /**
     * @return \OxidEsales\EshopCommunity\Internal\Common\Database\QueryBuilderFactoryInterface
     */
    public static function getQueryBuilderFactory()
    {
        $container = ContainerFactory::getInstance()->getContainer();

        /** @var \OxidEsales\EshopCommunity\Internal\Common\Database\QueryBuilderFactoryInterface $queryBuilderFactory */
        return $container->get(QueryBuilderFactoryInterface::class);
    }

}