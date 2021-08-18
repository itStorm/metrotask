<?php

namespace Metrotask\Commands;

use Metrotask\Common\OfferFilterIterator;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Metrotask\Services\ProductReader;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Monolog\Logger;

class ProductsLoadCommand extends Command
{
    protected static $defaultName = 'metrotask:product-load';

    protected static $defaultDescription = 'Load products and show the count of them';

    /**
     * @var string
     */
    private $path;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var ProductReader
     */
    private $productReader;

    /**
     * @var string
     */
    private $searchField;

    /**
     * @var string
     */
    private $searchOperator;

    /**
     * @var array
     */
    private $searchFilter;

    /**
     * @param string $productsJsonPath
     * @param ProductReader $productReader
     * @param Logger $logger
     */
    public function __construct(
        string        $productsJsonPath,
        ProductReader $productReader,
        Logger        $logger
    )
    {
        $this->path = $productsJsonPath;
        $this->productReader = $productReader;
        $this->logger = $logger;

        $this->logger->log(LogLevel::INFO, self::class . ' started...');
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp("This command allows you to get count of product that suit searched params." .
            "\nExample: `metrotask:product-load count_by_price_range 12.00 145.80` OR `metrotask:product-load count_by_vendor_id 42`")
            ->addArgument('search_command', InputArgument::OPTIONAL, 'Search command count_by_{field name} or count_by_{field name}_range')
            ->addArgument('search_values', InputArgument::IS_ARRAY, 'Search value or two values separated by space');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $searchCommand = $input->getArgument('search_command');
        $searchValues = $input->getArgument('search_values');

        if (!$this->processArguments($searchCommand, $searchValues)) {
            $this->logger->log(LogLevel::ERROR, self::class . ' failed');
            throw new InvalidArgumentException();
        }

        $this->logger->log(LogLevel::INFO, 'Begin request');
        $output->writeln('==RESULT==');

        $iterator = new OfferFilterIterator($this->productReader->read($this->path)->getIterator(), [
            'field' => $this->searchField,
            'values' => $this->searchFilter,
            'operator' => $this->searchOperator,
        ]);
        $count = 0;
        foreach ($iterator as $ignored) {
            $count++;
        }
        $output->writeln($count);

        $this->logger->log(LogLevel::INFO, self::class . ' finished');
        return self::SUCCESS;
    }

    /**
     * @param string|null $searchCommand
     * @param array $searchValues
     * @return bool
     */
    protected function processArguments(?string $searchCommand, array $searchValues): bool
    {
        if ($searchCommand === null) {
            return true;
        }
        if (empty($searchValues) || count($searchValues) > 2) {
            return false;
        }

        $result = preg_match('/^count_by_([_a-z]+)(_range$|$)/U', $searchCommand, $matches);
        if (!$result) {
            return false;
        }
        $this->searchField = lcfirst(str_replace('_', '', ucwords($matches[1], '_')));
        $this->searchOperator = $matches[2] ? trim($matches[2], '_') : null;

        if ($this->searchOperator && count($searchValues) < 2) {
            return false;
        }

        $this->searchFilter = $searchValues;

        return true;
    }
}