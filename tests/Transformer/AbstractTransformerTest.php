<?php

namespace Transformer;

use ETL\Context;
use ETL\Transformer\AbstractTransformer;
use PHPUnit\Framework\TestCase;

class AbstractTransformerTest extends TestCase
{
    protected $anonymousClassFromAbstract;

    protected function createAbstractInstance(array $attributes = [])
    {
        return new class ($attributes) extends AbstractTransformer {
            public function transform(Context $context): Context
            {
                return $context->transform([$this, 'callback'], $this->attributes);
            }

            public function callback(string $value)
            {
                return $value.'Test';
            }
        };
    }

    public function setUp(): void
    {
        // Create a new instance from the abstract class
        $this->anonymousClassFromAbstract = $this->createAbstractInstance();
    }

    public function test__construct()
    {
        $this->assertInstanceOf(AbstractTransformer::class, $this->anonymousClassFromAbstract);
        $this->assertObjectHasAttribute(
            'attributes',
            $this->anonymousClassFromAbstract,
            'Testing abstract class has attributes array'
        );
    }

    public function testTransform()
    {
        $context = new Context(['hello' => 'world', 'property' => 'test']);
        $expected = new Context(['hello' => 'worldTest', 'property' => 'testTest']);
        $actual = $this->anonymousClassFromAbstract->transform($context);

        $this->assertInstanceOf(Context::class, $actual, 'Test transform returns Context instance');
        $this->assertSame($expected['hello'], $actual['hello'], 'Test transform return Context with Test appended to values');
        $this->assertSame($expected['property'], $actual['property'], 'Test transform return Context with all properties transformed');

        $instance = $this->createAbstractInstance(['hello']); // Only apply to hello attribute
        $context = new Context(['hello' => 'world', 'property' => 'test']);
        $expected = new Context(['hello' => 'worldTest', 'property' => 'test']);
        $actual = $instance->transform($context);

        $this->assertSame($expected['hello'], $actual['hello'], 'Test transform has appended Test to value');
        $this->assertSame($expected['property'], $actual['property'], 'Test transform has ignored appending Test to value');
    }

    public function testInvokable()
    {
        $instance = $this->createAbstractInstance();
        $this->assertIsCallable($instance, 'Test transformer is invokable without calling transform()');

        $context = new Context(['hello' => 'world']);
        $expected = new Context(['hello' => 'worldTest']);
        $actual = $instance(clone $context);
        $this->assertSame($expected['hello'], $actual['hello'], 'Test transformer performs a transform when invoked');
        $this->assertSame($actual['hello'], $instance->transform($context)['hello'], 'Test transform method and invokable returns same Context');
    }
}
