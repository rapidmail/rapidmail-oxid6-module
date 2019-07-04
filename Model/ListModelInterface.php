<?php

namespace Rapidmail\Oxid6Module\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * CustomerModel
 */
interface ListModelInterface
{

    /**
     * @return int
     */
    public function getMaxPageSize();

    /**
     * @param array $params
     * @return ArrayCollection
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    public function getItems($params = []);

    /**
     * @return int
     */
    public function getItemCount();

}