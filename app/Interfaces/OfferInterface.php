<?php

namespace Metrotask\Interfaces;

/**
 * Interface of Data Transfer Object, that represents external JSON data
 */
interface OfferInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * Get field name marked as Index
     * @return string
     */
    public static function getIndexName(): string;
}