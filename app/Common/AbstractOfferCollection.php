<?php

namespace Metrotask\Common;

use Metrotask\Interfaces\OfferCollectionInterface;
use Metrotask\Interfaces\OfferInterface;

abstract class AbstractOfferCollection implements OfferCollectionInterface
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        foreach ($data as $item) {
            if (is_array($item) && $offer = $this->createOfferInstance($item)) {
                $this->data[$offer->getId()] = $offer;
            }
        }
    }

    /**
     * @param array $item
     * @return OfferInterface|null
     */
    abstract protected function createOfferInstance(array $item): ?OfferInterface;

    public function get(int $index): OfferInterface
    {
        return $this->data[$index];
    }

    public function getIterator(): \Iterator
    {
        foreach ($this->data as $item) {
            yield $item;
        }
    }
}