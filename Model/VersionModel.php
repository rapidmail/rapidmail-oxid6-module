<?php

namespace Rapidmail\Oxid6Module\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Query\QueryBuilder;
use Rapidmail\Oxid6Module\Helper\VersionHelper;

/**
 * VersionModel
 */
class VersionModel extends DatabaseModel implements ListModelInterface
{

    /**
     * @inheritDoc
     */
    public function getItems($params = [])
    {

        $collection = new ArrayCollection();

        foreach ($this->getGenerator($params) as $item) {

            $item['pluginversion'] = VersionHelper::PLUGIN_VERSION;

            $collection->set($item['OXID'], array_change_key_case($item, CASE_LOWER));

        }

        return $collection;

    }

    /**
     * @inheritDoc
     */
    protected function prepareQuery(QueryBuilder $qb, array $params = [])
    {

        $qb
            ->select('v.OXID, v.OXVERSION, v.OXEDITION')
            ->from('oxshops', 'v');

        return parent::prepareQuery($qb, $params);

    }

}