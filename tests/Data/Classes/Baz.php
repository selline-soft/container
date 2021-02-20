<?php
namespace Selline\Di\Tests\Data\Classes;

class Baz implements BazInterface
{
    public function __construct(
        private BarInterface $bar
    ){}

    public function getBar()
    {
        return $this->bar;
    }
}