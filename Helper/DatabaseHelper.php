<?php

namespace Rapidmail\Oxid6Module\Helper;

use OxidEsales\Eshop\Core\Database\Adapter\Doctrine\Database;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\EshopCommunity\Internal\Common\Database\QueryBuilderFactory;

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
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \ReflectionException
     */
    public static function getQueryBuilderFactory()
    {

        $database = static::getDatabaseAdapter();
        $r = new \ReflectionMethod(Database::class, 'getConnection');
        $r->setAccessible(true);

        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $r->invoke($database);

        return new QueryBuilderFactory($connection);

    }

}