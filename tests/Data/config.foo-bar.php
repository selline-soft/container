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

    'some_named_service' => [
        '__class' => function(\Psr\Container\ContainerInterface $container, \Selline\Di\Tests\Data\Classes\Big $big, $name) {
            return new \Selline\Di\Tests\Data\Closured($big, $name);
        },
        'name' => 'closure id'
    ]
];