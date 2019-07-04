<?php

namespace Rapidmail\Oxid6Module\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Query\QueryBuilder;

class CustomerModel extends DatabaseModel implements ListModelInterface
{

    private $_aBlacklistedFields = [
        'oxpassword',
        'oxpasssalt'
    ];

    /**
     * @inheritDoc
     */
    public function getItems($params = [])
    {

        $collection = new ArrayCollection();

        foreach ($this->getGenerator($params) as $item) {

            $result = array_change_key_case($item, CASE_LOWER);

            foreach ($this->_aBlacklistedFields as $fieldName) {
                unset($result[$fieldName]);
            }

            $collection->set($result['oxid'], $result);

        }

        return $collection;

    }

    /**
     * @inheritDoc
     */
    protected function prepareQuery(QueryBuilder $qb, array $params = [])
    {

        $qb
            ->select('u.*')
            ->addSelect('IF(n.OXDBOPTIN = 1,1,0) AS newsletter')
            ->from('oxuser', 'u')
            ->leftJoin('u', 'oxnewssubscribed', 'n', 'u.oxid = n.oxuserid')
            ->where($qb->expr()->eq('n.OXDBOPTIN', '1'));

        return parent::prepareQuery($qb, $params);

    }

}