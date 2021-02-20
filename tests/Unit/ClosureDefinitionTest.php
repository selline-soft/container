<?php
namespace Selline\Di\Tests\Unit;
use PHPUnit\Framework\TestCase;
use Selline\Di\Definitions\ClosureDefinition;

class ClosureDefinitionTest extends TestCase
{
    public function testNotExistingFunction()
    {
        $def = new ClosureDefinition([
            '__class' => 'somefunc',
            'arg1' => 'val1'
        ]);

        $this->assertSame(['arg1' => 'val1'], $def->getArguments());

        $this->expectExceptionMessage('Function somefunc() does not exist');
        $def->getUnresolvedArguments();
    }
}