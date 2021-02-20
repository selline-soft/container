<?php
namespace Selline\Di;
use Psr\Container\ContainerInterface;
use Selline\Di\Definitions\DefinitionFactoryInterface;
use Selline\Di\Definitions\ServiceDefinitionInterface;
use Selline\Di\Dependencies\ResolverInterface;
use Selline\Di\Exceptions\CircularReferenceException;
use Selline\Di\Exceptions\ServiceNotFoundException;

/**
 * Контейнер внедрения зависимостей
 *
 * @link https://en.wikipedia.org/wiki/Dependency_injection
 * @package Selline\Di
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class Container implements ContainerInterface
{
    /**
     * @var ServiceDefinitionInterface[]
     */
    private array $definitions = [];
    /**
     * @var object[]
     */
    private array $instances = [];
    /**
     * @var bool[]
     */
    private array $locks = [];


    /**
     * Конструктор контейнера.
     *
     * @param DefinitionFactoryInterface $definitionFactory
     * @param ResolverInterface $resolver
     */
    public function __construct(
        private DefinitionFactoryInterface $definitionFactory,
        private ResolverInterface $resolver
    ){
        $this->set(ContainerInterface::class, $this);
    }

    /**
     * Создает и возвращает объект сервиса по идентификатору.
     *
     * @param string $id идентификатор сервиса
     * @return object экземпляр класса сервиса
     *
     * @throws CircularReferenceException
     */
    public function get(string $id): object
    {
        if (!array_key_exists($id, $this->definitions)) {
            $this->set($id);
        }

        if (!isset($this->instances[$id])) {
            if ($this->isLocked($id)) {
                throw new CircularReferenceException($id);
            }
            $this->lock($id);

            $this->instances[$id] = $this->resolver->resolve($this, $this->definitions[$id]);
        }

        return $this->instances[$id];
    }

    /**
     * Проверяет наличие сервиса в контейнере.
     *
     * Сервис считается существующим в контейнере, если существует его определение
     * или его идентификатор является именем существующего класса.
     *
     * @param string $id идентификатор или имя класса сервиса
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->definitions[$id]) || class_exists($id);
    }

    /**
     * Добавляет в контейнер определение сервиса.
     *
     * Если экземпляр сервиса с заданным идентификатором существует, он будет удален и
     * вместо существующего определения сервиса с заданным идентификатором будет добавлено новое.
     *
     * @param string $id идентификатор сервиса
     * @param mixed $definition определение сервиса
     */
    public function set(string $id, mixed $definition = null): void
    {
        if (is_null($definition)) {
            $definition = $id;
        }

        if (is_object($definition)) {
            $this->instances[$id] = $definition;
            $this->definitions[$id] = $id;
        } else {
            unset($this->instances[$id]);
            unset($this->locks[$id]);


            if (
                is_array($definition)
                && !isset($definition[ServiceDefinitionInterface::CLASS_ARRAY_KEY])
                && class_exists($id)
            ) {
                $definition[ServiceDefinitionInterface::CLASS_ARRAY_KEY] = $id;
            }

            $this->definitions[$id] = $this->definitionFactory->create($definition);
        }
    }

    public function setMultiple(array $config)
    {
        foreach ($config as $id=>$definition) {
            $this->set($id, $definition);
        }
    }


    public function lock(string $id): void
    {
        $this->locks[$id] = true;
    }

    public function isLocked(string $id): bool
    {
        return isset($this->locks[$id]);
    }

}