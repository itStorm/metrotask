<?php
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Metrotask\Application;

$containerBuilder = new ContainerBuilder();
$loader = new YamlFileLoader($containerBuilder, new FileLocator(implode(DIRECTORY_SEPARATOR, [__DIR__, 'config'])));
$loader->load('services.yaml');
$containerBuilder->compile();

$application = new Application();
$application->loadCommands($containerBuilder)->run();

