<?php
namespace Selline\Di\Definitions;
use Closure;
use ReflectionMethod;
use ReflectionParameter;
use Selline\Di\Exceptions\ContainerException;

/**
 * Определение сервиса
 *
 * Сервис в контейнере может быть определен одним из следующих способов:
 *
 * 1. Строка, содержащая имя класса
 * 2. Массив, включающий элемент __class с именем класса
 * 3. Замыкание, возвращающее объект
 *
 * @package Selline\Di\Definitions
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
abstract class AbstractServiceDefinition implements ServiceDefinitionInterface
{
    /**
     * @var string|Closure имя класса или замыкание
     */
    protected string|Closure $className;
    /**
     * @var array прелустановленные значения именованных параметров
     */
    protected array $arguments = [];



    /**
     * @inheritDoc
     */
    public function getClass(): string|Closure
    {
        return $this->className;
    }

    /**
     * @inheritDoc
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return array
     * @throws ContainerException
     */
    public function getUnresolvedArguments(): array
    {
        $reflection = $this->createReflection();

        if (is_null($reflection)) {
            return [];
        }

        $reflected = $reflection->getParameters();

        $instanceArguments = [];

        foreach ($reflected as $index => $argument) {
            $instanceArguments[$index] = array_key_exists($argument->getName(), $this->arguments)
                ? $this->arguments[$argument->getName()]
                : $argument;
        }

        return $instanceArguments;
    }

    /**
     * Возвращает отражение конструктора или замыкания
     * @throws ContainerException
     * @return ReflectionMethod|null
     */
    abstract protected function createReflection(): ReflectionMethod|null;

    abstract public function invoke(array $parameters): object;
}