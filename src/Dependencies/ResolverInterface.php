<?php
namespace Selline\Di\Dependencies;

use Psr\Container\ContainerInterface;
use Selline\Di\Definitions\ServiceDefinitionInterface;

interface ResolverInterface
{
    public function resolve(ContainerInterface $container, ServiceDefinitionInterface $definition): object;
}