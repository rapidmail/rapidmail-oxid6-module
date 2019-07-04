<?php

namespace Rapidmail\Oxid6Module\Response;

/**
 * ResponseInterface
 */
interface ResponseInterface extends \JsonSerializable
{

    /**
     * @return int
     */
    public function getStatusCode();

}