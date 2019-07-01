<?php

namespace Rapidmail\Oxid6Module\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\Eshop\Application\Model\Article;

/**
 * ProductModel
 */
class ProductModel extends DatabaseModel implements ListModelInterface
{

    /**
     * @inheritDoc
     */
    public function getItems($params = [])
    {
        $collection = new ArrayCollection();

        foreach ($this->getGenerator($params) as $item) {

            /** @var Article $article */
            $article = oxNew(Article::class);
            $article->assign($item);

            $result = array_merge(
                array_change_key_case($item, CASE_LOWER),
                [
                    'oxnid' => $item['OXID'],
                    'deeplink' => $article->getBaseSeoLink(0, true),
                    'image' => $article->getMasterZoomPictureUrl(1),
                    'oxlongdesc' => $article->getLongDesc(),
                    'originalprice' => $item['OXPRICE'],
                    'oxprice' => $article->getPrice()->getPrice()
                ]
            );

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
            ->select('a.*')
            ->addSelect('e.oxlongdesc')
            ->from('oxarticles', 'a')
            ->leftJoin('a', 'oxartextends', 'e', 'a.oxid = e.oxid');

        return parent::prepareQuery($qb, $params);

    }

}