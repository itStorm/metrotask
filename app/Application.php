<?php
declare(strict_types=1);

namespace Metrotask;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\TaggedContainerInterface;

class Application extends BaseApplication
{
    /**
     * @param TaggedContainerInterface $container
     * @return $this
     */
    public function loadCommands(TaggedContainerInterface $container): self
    {
        foreach (array_keys($container->findTaggedServiceIds('console.command')) as $id) {
            /** @var Command $command */
            $command = $container->get($id);
            $this->add($command);
        }

        return $this;
    }
}