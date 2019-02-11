<?php

namespace Demv\Mapper\Tests\Mapper;

use Codeception\Specify;
use Demv\Mapper\Mapper;
use PHPUnit\Framework\TestCase;

/**
 * Class ConstraintMapperTest
 * @package Demv\Mapper\Tests\Mapper
 */
final class MapperTest extends TestCase
{
    use Specify;

    public function testMapConstraint()
    {
        $this->specify('Ohne Constraint', function () {
            $mapper = new Mapper();
            $mapper->map('foo.bar', function (Mapper $mapper, $value) {
                $mapper->setAttribute('my.value', $value);
            });

            $mapped = $mapper->applyMapping([]);
            $this->assertEquals(['my' => ['value' => null]], $mapped);
        });

        $this->specify('Mit Constraint und ohne Value', function () {
            $mapper = new Mapper();
            $mapper->map('foo.bar', function (Mapper $mapper, int $value) {
                $mapper->setAttribute('my.value', $value);
            }, function ($value): bool {
                return !empty($value);
            });

            $mapped = $mapper->applyMapping([]);
            $this->assertEmpty($mapped);
        });

        $this->specify('Mit Constraint und leerem Value', function () {
            $mapper = new Mapper();
            $mapper->map('foo.bar', function (Mapper $mapper, int $value) {
                $mapper->setAttribute('my.value', $value);
            }, function ($value): bool {
                return !empty($value);
            });

            $mapped = $mapper->applyMapping(['foo' => ['bar' => null]]);
            $this->assertEmpty($mapped);
        });
    }

    public function testTranslate()
    {
        $mapper = new Mapper();
        $mapper->translate('foo', 'bar');

        $mapped = $mapper->applyMapping(['foo' => 42]);
        $this->assertEquals(['bar' => 42], $mapped);
    }

    public function testKeep()
    {
        $mapper = new Mapper();
        $mapper->keep('foo');

        $mapped = $mapper->applyMapping(['foo' => 42, 'bar' => 23]);
        $this->assertEquals(['foo' => 42], $mapped);
    }

    public function testKeepAllUnmatched()
    {
        $mapper = new Mapper();
        $mapper->keep('foo');
        $mapper->setKeepAllUnmatched(true);

        $mapped = $mapper->applyMapping(['foo' => 42, 'bar' => 23]);
        $this->assertEquals(['foo' => 42, 'bar' => 23], $mapped);

        $mapper = new Mapper();
        $mapper->keep('foo.a');

        $mapped = $mapper->applyMapping(['foo' => ['a' => 'b', 'x' => 'y']]);
        $this->assertEquals(['foo' => ['a' => 'b']], $mapped);

        $mapper->setKeepAllUnmatched(true);

        $mapped = $mapper->applyMapping(['foo' => ['a' => 'b', 'x' => 'y']]);
        $this->assertEquals(['foo' => ['a' => 'b', 'x' => 'y']], $mapped);
    }
}
