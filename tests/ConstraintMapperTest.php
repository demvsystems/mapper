<?php

namespace Demv\Mapper\Test;

use Codeception\Specify;
use Demv\Mapper\Mapper;
use PHPUnit\Framework\TestCase;

final class ConstraintMapperTest extends TestCase
{
    use Specify;

    public function testConstraint()
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
}
