<?php

namespace Metrotask\Product;

use Metrotask\Common\AbstractOffer;

class Product extends AbstractOffer
{
    public static function getIndexName(): string
    {
        return 'offerId';
    }
}