<?php

namespace Metrotask\Product;

use Metrotask\Common\AbstractOfferCollection;
use Metrotask\Interfaces\OfferInterface;

class ProductCollection extends AbstractOfferCollection
{
    protected function createOfferInstance(array $item): ?OfferInterface
    {
        return isset($item[Product::getIndexName()]) ? new Product($item) : null;
    }
}