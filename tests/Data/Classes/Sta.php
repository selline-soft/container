<?php
namespace Selline\Di\Tests\Data\Classes;

class Sta
{
    public static function getName(): string
    {
        return static::class;
    }

    private function __construct(){}
}