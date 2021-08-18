<?php

namespace Metrotask\Interfaces;

interface DataLoader
{
    /**
     * Return data as associated array
     * @param string $source
     * @return array
     */
    public function load(string $source): array;
}