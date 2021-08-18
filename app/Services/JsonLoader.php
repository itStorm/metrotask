<?php

namespace Metrotask\Services;

use Metrotask\Interfaces\DataLoader;

class JsonLoader implements DataLoader
{
    public function load(string $source): array
    {
        $data = json_decode(file_get_contents($source), true);
        return $data ?? [];
    }
}