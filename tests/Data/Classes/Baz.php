<?php
namespace Selline\Di\Tests\Data\Classes;

class Baz implements BazInterface
{
    public function __construct(
        public BarInterface $bar
    ){}
}