<?php
namespace Selline\Di\Tests\Unit;
use PHPUnit\Framework\TestCase;
use Selline\Di\Container;
use Selline\Di\Definitions\DefinitionFactory;
use Selline\Di\Dependencies\Resolver;
use Selline\Di\Tests\Data\Classes\Bar;
use Selline\Di\Tests\Data\Classes\Baz;
use Selline\Di\Tests\Data\Classes\Big;
use Selline\Di\Tests\Data\Classes\Foo;

class ResolvePropertyTest extends TestCase
{
    private Container $di;

    public function setUp(): void
    {
        $this->di = new Container(
            new DefinitionFactory(),
            new Resolver()
        );
        $this->di->setMultiple(require dirname(__DIR__) . '/Data/config.foo-bar.php');
    }

    public function tearDown(): void
    {
        unset($this->di);
    }

    public function testAbstractDependencyResolved()
    {
        $object = $this->di->get(Big::class);
        $this->assertInstanceOf(Bar::class, $object->getBar());
        $this->assertInstanceOf(Foo::class, $object->getFoo());
        $this->assertSame('test name', $object->getName());
    }
}