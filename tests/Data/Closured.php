<?php
namespace Selline\Di\Tests\Data;

class Closured
{
    public function __construct(
        public mixed $big,
        public string $name
    ){}
}