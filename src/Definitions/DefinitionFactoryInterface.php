<?php
namespace Selline\Di\Definitions;

/**
 * Interface DefinitionFactoryInterface
 *
 * @package Selline\Di\Factories
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
interface DefinitionFactoryInterface
{
    public function create(mixed $definition): ServiceDefinitionInterface;
}