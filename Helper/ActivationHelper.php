<?php

namespace Rapidmail\Oxid6Module\Helper;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * ActivationHelper
 */
class ActivationHelper
{

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \ReflectionException
     */
    public static function onActivate()
    {

        $queryBuilder = DatabaseHelper::getQueryBuilderFactory()->create();

        $queryBuilder
            ->insert('oxgroups')
            ->values([
                'OXID' => '?',
                'OXACTIVE' => '?',
                'OXTITLE' => '?',
                'OXTITLE_1' => '?'
            ])
            ->setParameters([
                    'rmoxconnect',
                    '1',
                    'Rapidmail OXID eShop connector',
                    'Rapidmail OXID eShop connector'
                ]
            );

        try {
            $queryBuilder->execute();
        } catch (UniqueConstraintViolationException $e) {
            // User group exists so we can simply ignore
        }

    }

}