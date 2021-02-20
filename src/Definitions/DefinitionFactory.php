<?php
namespace Selline\Di\Definitions;
use Selline\Di\Exceptions\ClassNotFoundException;
use Selline\Di\Exceptions\MissedIdentifierException;
use Closure;

final class DefinitionFactory implements DefinitionFactoryInterface
{
    public function __construct(
        private string $closureDefinitionClass = ClosureDefinition::class,
        private string $arrayDefinitionClass = ArrayDefinition::class
    ){}

    /**
     * @param mixed $definition
     * @return ServiceDefinitionInterface
     * @throws ClassNotFoundException
     * @throws MissedIdentifierException
     */
    public function create(mixed $definition): ServiceDefinitionInterface
    {
        $this->normalizeDefinition($definition);

        $definitionClass = $definition[ServiceDefinitionInterface::CLASS_ARRAY_KEY] instanceof Closure
            ? $this->closureDefinitionClass
            : $this->arrayDefinitionClass;

        return new $definitionClass($definition);
    }

    /**
     * @param mixed $definition
     * @throws MissedIdentifierException
     */
    private function normalizeDefinition(mixed &$definition)
    {
        if (!is_array($definition)) {
            $definition = [ServiceDefinitionInterface::CLASS_ARRAY_KEY => $definition];
        }

        $identifier = $definition[ServiceDefinitionInterface::CLASS_ARRAY_KEY]
            ?? throw new MissedIdentifierException();
    }
}

