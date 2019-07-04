<?php

namespace Rapidmail\Oxid6Module\Model;

use Doctrine\Common\Collections\ArrayCollection;
use OxidEsales\Eshop\Core\ShopVersion;
use OxidEsales\Facts\Edition\EditionSelector;
use Rapidmail\Oxid6Module\Helper\VersionHelper;

/**
 * VersionModel
 */
class VersionModel implements ListModelInterface
{

    /** @var string */
    const OXID = '3a952ff0b7b6c57c45f8c10148134734';

    /**
     * @var EditionSelector
     */
    protected $editionSelector;

    /**
     * Constructor
     *
     * @param EditionSelector $editionSelector
     */
    public function __construct(EditionSelector $editionSelector)
    {
        $this->editionSelector = $editionSelector;
    }

    /**
     * @inheritDoc
     */
    public function getItems($params = [])
    {

        $collection = new ArrayCollection();

        $collection->set(
            self::OXID,
            [
                'oxid' => self::OXID,
                'oxversion' => ShopVersion::getVersion(),
                'oxedition' => $this->editionSelector->getEdition(),
                'pluginversion' => VersionHelper::PLUGIN_VERSION
            ]
        );

        return $collection;

    }

    /**
     * @inheritDoc
     */
    public function getMaxPageSize()
    {
        return 1;
    }

    /**
     * @inheritDoc
     */
    public function getItemCount()
    {
        return 1;
    }

}