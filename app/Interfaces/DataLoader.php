<?php

namespace Metrotask\Interfaces;

/**
 * Provide interface for getting data from any source
 */
interface DataLoader
{
    /**
     * Return data as associated array
     * @param string $source
     * @return array
     */
    public function load(string $source): array;
}