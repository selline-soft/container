<?php
namespace Selline\Di\Tests\Data\Classes;

class Cir1
{
    public function __construct(
        private Cir2 $a
    ){}
}