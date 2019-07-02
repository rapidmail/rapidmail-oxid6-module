<?php

namespace Rapidmail\Oxid6Module\Core;

/**
 * SeoDecoder
 *
 * Compatibility layer to map v4/v5 api requests to the appropriate controllers.
 * This should be considered as a temporary solution because it will "hijack" oxrest URLs
 * but on the other hand the v4/v5 plugin did this as well ¯\_(ツ)_/¯
 *
 * @mixin \OxidEsales\Eshop\Core\SeoDecoder
 */
class SeoDecoder extends SeoDecoder_parent
{

    /**
     * @var string[]
     */
    protected $controllerMap = [
        'user' => 'rm_customer',
        'articlelist' => 'rm_product',
        'shops' => 'rm_version'
    ];

    /**
     * @inheritDoc
     */
    public function decodeUrl($seoUrl)
    {

        $matched = preg_match(
            '~oxrest/(?:ox)?list/ox(?P<cl>user|articlelist|shops)(?P<page>/\d+)?(?P<pageSize>/\d+)?~',
            $seoUrl,
            $matches
        );

        if ($matched === false || !isset($this->controllerMap[$matches['cl']])) {
            return parent::decodeUrl($seoUrl);
        }

        $result = ['cl' => $this->controllerMap[$matches['cl']]];

        if ($matches['page'] !== null) {
            $result['page'] = (int)ltrim($matches['page'], '/');
        }

        if ($matches['pageSize'] !== null) {
            $result['pageSize'] = (int)ltrim($matches['pageSize'], '/');
        }

        return $result;

    }

}