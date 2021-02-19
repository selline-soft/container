<?php
namespace Selline\Di\Definitions;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Selline\Di\Exceptions\ContainerException;

final class ArrayDefinition extends AbstractServiceDefinition
{
    public function __construct(array $definition)
    {
        $this->className = $definition[self::CLASS_ARRAY_KEY];
        unset($definition[self::CLASS_ARRAY_KEY]);
        $this->arguments = $definition;
    }

    protected function createReflection(): ReflectionMethod|null
    {
        try {
            $reflection = new ReflectionClass($this->getClass());
            if (!$reflection->isInstantiable()) {
                throw new ContainerException("Service is not instantiable");
            }
            return $reflection->getConstructor();

        } catch (ReflectionException $exception) {
            throw new ContainerException($exception->getMessage());
        }
    }

    public function invoke(array $parameters): object
    {
        $className = $this->getClass();
        return new $className(...$parameters);
    }
}