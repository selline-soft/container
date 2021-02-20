<?php
namespace Selline\Di\Definitions;
use Closure;
use function Psalm\getArguments;

/**
 * Определение сервиса
 *
 * Сервис в контейнере может быть определен одним из следующих способов:
 *   1. Массив, включающий элемент __class с именем класса
 *   2. Замыкание, возвращающее объект
 */
interface ServiceDefinitionInterface
{
    const CLASS_ARRAY_KEY = '__class';

    /**
     * Возвращает имя класса или замыкание, создающее экземпляр класса.
     *
     * @return string|Closure
     * @psalm-return class-string|Closure
     */
    public function getClass(): string|Closure;

    /**
     * Возвращает предустановленные конфигурацией значения именованных параметров конструктора (замыкания)
     *
     * При создании экземпляра класса (при вызове замыкания) если в массиве аргументов
     * существует значение, связанное с одноименным параметру ключом, оно будет использовано в качестве
     * значения параметра. Если такого значения нет, будет произведена попытка решить данную
     * зависимость через контейнер.
     *
     * @see getUnresolvedArguments()
     * @return array
     */
    public function getArguments(): array;

    /**
     * Возвращает массив аргументов, не представленных в конфигнурации
     * @see getArguments()
     * @return array
     */
    public function getUnresolvedArguments(): array;


    public function invoke(array $parameters): object;
}