<?php

namespace Demv\Mapper\Tests\Mapper;

use Codeception\Specify;
use Demv\Mapper\Mapper;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class ConstraintMapperTest
 * @package Demv\Mapper\Tests\Mapper
 */
final class MapperTest extends TestCase
{
    use Specify;

    public function testMapConstraint(): void
    {
        $this->specify('Ohne Constraint', function (): void {
            $mapper = new Mapper();
            $mapper->map('foo.bar', function (Mapper $mapper, $value): void {
                $mapper->setAttribute('my.value', $value);
            });

            $mapped = $mapper->applyMapping([]);
            $this->assertEquals(['my' => ['value' => null]], $mapped);
        });

        $this->specify('Mit Constraint und ohne Value', function (): void {
            $mapper = new Mapper();
            $mapper->map('foo.bar', function (Mapper $mapper, int $value): void {
                $mapper->setAttribute('my.value', $value);
            }, function ($value): bool {
                return !empty($value);
            });

            $mapped = $mapper->applyMapping([]);
            $this->assertEmpty($mapped);
        });

        $this->specify('Mit Constraint und leerem Value', function (): void {
            $mapper = new Mapper();
            $mapper->map('foo.bar', function (Mapper $mapper, int $value): void {
                $mapper->setAttribute('my.value', $value);
            }, function ($value): bool {
                return !empty($value);
            });

            $mapped = $mapper->applyMapping(['foo' => ['bar' => null]]);
            $this->assertEmpty($mapped);
        });
    }

    public function testTranslate(): void
    {
        $mapper = new Mapper();
        $mapper->translate('foo', 'bar');

        $mapped = $mapper->applyMapping(['foo' => 42]);
        $this->assertEquals(['bar' => 42], $mapped);
    }

    public function testKeep(): void
    {
        $mapper = new Mapper();
        $mapper->keep('foo');

        $mapped = $mapper->applyMapping(['foo' => 42, 'bar' => 23]);
        $this->assertEquals(['foo' => 42], $mapped);
    }

    public function testKeepAllUnmatched(): void
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

    public function testWarnOnDuplicateTranslations(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('There is already a translation for Hausnummer with street_nr');

        $mapper = new Mapper();
        $mapper->setWarnOnDuplicateTranslations(true);
        $mapper->translate('street_nr', 'Hausnummer');
        $mapper->translate('street_number', 'Hausnummer');
    }

    public function testFillMissingValues(): void
    {
        $mapper = new Mapper();
        $mapper->translate('street_nr', 'Hausnummer');
        $data = $mapper->applyMapping([]);
        $this->assertEquals(['Hausnummer' => null], $data);

        $mapper->setFillMissingValues(false);
        $mapper->translate('street_nr', 'Hausnummer');
        $data = $mapper->applyMapping([]);
        $this->assertEquals([], $data);
    }

    public function testOverride(): void
    {
        $mapper = new Mapper();
        $mapper->translate('street_nr', 'Hausnummer');
        $mapper->translate('street_number', 'Hausnummer');
        $data = ['street_nr' => '42a', 'street_number' => '23'];

        $data = $mapper->applyMapping($data);
        $this->assertEquals(['Hausnummer' => '42a'], $data);

        $mapper->setAllowOverride(true);
        $data = ['street_nr' => '42a', 'street_number' => '23'];
        $data = $mapper->applyMapping($data);
        $this->assertEquals(['Hausnummer' => '23'], $data);
    }

    public function testDontOverrideDuplicateTranslationWithNull(): void
    {
        $mapper = new Mapper();
        $mapper->translate('street_nr', 'Hausnummer');
        $mapper->translate('street_number', 'Hausnummer');

        $data = ['street_nr' => '42a'];
        $data = $mapper->applyMapping($data);
        $this->assertEquals(['Hausnummer' => '42a'], $data);

        $data = ['street_number' => '23'];
        $data = $mapper->applyMapping($data);
        $this->assertEquals(['Hausnummer' => '23'], $data);
    }
}
