<?php
return [
    \Selline\Di\Tests\Data\Classes\BarInterface::class => [
        '__class' => \Selline\Di\Tests\Data\Classes\Bar::class
    ],

    \Selline\Di\Tests\Data\Classes\BazInterface::class => [
        '__class' => \Selline\Di\Tests\Data\Classes\Baz::class
    ],
    
    \Selline\Di\Tests\Data\Classes\Big::class => [
        '__class' => \Selline\Di\Tests\Data\Classes\Big::class,
        'name' => 'test name',
    ],
];