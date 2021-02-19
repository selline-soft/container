<?php
namespace Selline\Di\Dependencies;
use Psr\Container\ContainerInterface;
use ReflectionParameter;
use Selline\Di\Definitions\ServiceDefinitionInterface;
use Selline\Di\Exceptions\ContainerException;


class Resolver implements ResolverInterface
{
    /**
     * @param ContainerInterface $container
     * @param ServiceDefinitionInterface $definition
     * @return object
     * @throws ContainerException
     * @throws \ReflectionException
     */
    public function resolve(ContainerInterface $container, ServiceDefinitionInterface $definition): object
    {
        $arguments = $definition->getUnresolvedArguments();

        if (!empty($arguments)) {
            foreach ($arguments as $index => $argument) {
                if ($argument instanceof ReflectionParameter) {

                    $dependency = $argument->getType();

                    if (is_null($dependency)) {
                        if ($argument->isDefaultValueAvailable()) {
                            $arguments[$index] = $argument->getDefaultValue();
                        } else {
                            throw new ContainerException("Unable to resolve dependencies");
                        }
                    } else {
                        $arguments[$index] = $container->get($dependency->getName());
                    }
                }
            }
        }

        return $definition->invoke($arguments);
    }
}