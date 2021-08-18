<?php

namespace Metrotask\Common;

use Metrotask\Interfaces\OfferInterface;

/**
 * Base abstract class for types of loaded data
 */
abstract class AbstractOffer implements OfferInterface
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
        $this->data = $data;
    }

    public function getId(): int
    {
        return $this->getField(static::getIndexName());
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getField($name)
    {
        return $this->getData()[$name] ?? null;
    }
}