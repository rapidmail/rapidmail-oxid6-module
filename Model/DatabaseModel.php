<?php

namespace Rapidmail\Oxid6Module\Model;

use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;
use OxidEsales\EshopCommunity\Internal\Common\Database\QueryBuilderFactoryInterface;

/**
 * DatabaseModel
 */
class DatabaseModel
{

    /**
     * @var DatabaseInterface
     */
    private $dbAdapter;

    /**
     * @var QueryBuilderFactoryInterface
     */
    private $queryBuilderFactory;

    /**
     * Constructor
     *
     * @param DatabaseInterface $dbAdapter
     * @param QueryBuilderFactoryInterface $qbFactory
     */
    public function __construct(
        DatabaseInterface $dbAdapter,
        QueryBuilderFactoryInterface $qbFactory
    ) {
        $this->dbAdapter = $dbAdapter;
        $this->queryBuilderFactory = $qbFactory;
    }

    /**
     * @inheritDoc
     */
    public function getMaxPageSize()
    {
        return 250;
    }

    /**
     * @inheritDoc
     */
    public function getItemCount()
    {

        $qb = $this->queryBuilderFactory->create();

        $this
            ->prepareQuery($qb)
            ->select('count(*)');

        return (int)$this->dbAdapter->getOne($qb);

    }

    /**
     * @param array $params
     * @return \Generator
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    public function getGenerator($params = [])
    {

        $qb = $this->queryBuilderFactory->create();

        $rs = $this->dbAdapter->select($this->prepareQuery($qb, $params));

        if ($rs != false && $rs->count() > 0) {

            while (!$rs->EOF) {

                yield $rs->fields;

                $rs->fetchRow();

            }
        }

    }

    /**
     * @param QueryBuilder $qb
     * @param array $params
     * @return QueryBuilder
     */
    protected function prepareQuery(QueryBuilder $qb, array $params = [])
    {

        if (isset($params['offset'])) {
            $qb->setFirstResult($params['offset']);
        }

        if (isset($params['limit'])) {
            $qb->setMaxResults($params['limit']);
        }

        return $qb;

    }

}