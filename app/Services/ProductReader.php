<?php

namespace Metrotask\Services;

use Metrotask\Interfaces\OfferCollectionInterface;
use Metrotask\Interfaces\ReaderInterface;
use Metrotask\Product\ProductCollection;

class ProductReader implements ReaderInterface
{
    /**
     * @var JsonLoader
     */
    private $loader;

    public function __construct(JsonLoader $loader)
    {
        $this->loader = $loader;
    }

    public function read(string $input): OfferCollectionInterface
    {
       return new ProductCollection($this->loader->load($input));
    }
}