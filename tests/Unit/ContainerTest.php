<?php
namespace Selline\Di\Tests\Unit;
use PHPUnit\Framework\TestCase;
use Selline\Di\Container;
use Selline\Di\Definitions\DefinitionFactory;
use Selline\Di\Dependencies\Resolver;
use Selline\Di\Exceptions\MissedIdentifierException;
use Selline\Di\Exceptions\ServiceNotFoundException;
use Selline\Di\Tests\Data\Classes\BarInterface;
use Selline\Di\Tests\Data\Classes\Sta;
use Selline\Di\Tests\Data\Classes\UnimplementedInterface;

class ContainerTest extends TestCase
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

    public function testServiceNotFound()
    {
        $this->expectException(ServiceNotFoundException::class);
        $this->di->get(UnimplementedInterface::class);
    }

    public function testBar()
    {
        $bar = $this->di->get(BarInterface::class);
        $this->assertInstanceOf(BarInterface::class, $bar);
    }

    public function testNotInstantiableException()
    {
        $this->expectExceptionMessage("Class is not instantiable");
        $this->di->get(Sta::class);
    }

    public function testReflectionException()
    {
        $this->expectExceptionMessage("Class not found");
        $this->di->get('UnexistingClassName');
    }

    public function testMissedIdentifierException()
    {
        $this->expectException(MissedIdentifierException::class);
        $this->di->set('test', ['foo' => 'bar']);
        $this->di->get('test');
    }
}