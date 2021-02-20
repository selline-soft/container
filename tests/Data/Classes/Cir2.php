<?php
namespace Selline\Di\Tests\Data\Classes;


class Cir2
{
    public function __construct(
        private Cir1 $a
    ){}
}