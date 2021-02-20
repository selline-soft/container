<?php
namespace Selline\Di\Definitions;
use ReflectionException;
use ReflectionMethod;
use Selline\Di\Exceptions\ContainerException;
use ReflectionFunction;

final class ClosureDefinition extends AbstractServiceDefinition
{
    public function __construct(array $definition)
    {
        $this->className = $definition[self::CLASS_ARRAY_KEY];
        unset($definition[self::CLASS_ARRAY_KEY]);
        $this->arguments = $definition;
    }

    protected function createReflection(): ReflectionFunction
    {
        try {
            return new ReflectionFunction($this->getClass());
        } catch (ReflectionException $exception) {
            throw new ContainerException($exception->getMessage());
        }
    }

    public function invoke(array $parameters): object
    {
        $closure = $this->getClass();
        return $closure(...$parameters);
    }
}