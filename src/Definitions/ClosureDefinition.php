<?php
namespace Selline\Di\Definitions;
use ReflectionException;
use ReflectionMethod;
use Selline\Di\Exceptions\ContainerException;

final class ClosureDefinition extends AbstractServiceDefinition
{
    protected function createReflection(): ReflectionMethod
    {
        try {
            return new ReflectionMethod($this->getClass());
        } catch (ReflectionException $exception) {
            throw new ContainerException($exception->getMessage());
        }
    }

    public function invoke(array $parameters): object
    {
        // TODO: Implement invoke() method.
    }
}