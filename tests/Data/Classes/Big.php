<?php
namespace Selline\Di\Tests\Data\Classes;

class Big
{
    public function __construct(
        private BarInterface $bar,
        private Foo $foo,
        private string $name,
        private string $def = 'default'

    ){}


    public function getName()
    {
        return $this->name;
    }

    public function getFoo()
    {
        return $this->foo;
    }

    public function getBar()
    {
        return $this->bar;
    }
}