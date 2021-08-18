<?php

namespace Metrotask\Services;

use Metrotask\Interfaces\DataLoader;
use Monolog\Logger;

class JsonLoader implements DataLoader
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $source
     * @return array
     */
    public function load(string $source): array
    {
        $data = [];
        if ($remoteData = @file_get_contents($source)) {
            $data = json_decode($remoteData, true);
        } else {
            $this->logger->error(sprintf('Can\'t get data from source \'%s\'', $source));
        }
        return $data ?? [];
    }
}