<?php

namespace Demv\Mapper;

use Exception;
use SplStack;

/**
 * Class Mapper
 * @package Demv\Mapper
 */
class Mapper implements MapperInterface
{
    /**
     * @var callable[]
     */
    private $callbacks = [];
    /**
     * @var SplStack
     */
    private $keys;
    /**
     * @var array
     */
    private $attributes = [];
    /**
     * @var array
     */
    private $visited = [];
    /**
     * @var bool
     */
    private $debug = false;
    /**
     * @var bool
     */
    private $keepAllUnmatched = false;
    /**
     * @var bool
     */
    private $fillMissingValues = true;
    /**
     * @var bool
     */
    private $allowOverride = false;
    /**
     * @var bool
     */
    private $warnOnDuplicateTranslations = false;
    /**
     * @var array
     */
    private $translations = [];

    /**
     * Mapper constructor.
     */
    public function __construct()
    {
        $this->keys = new SplStack();
    }

    /**
     *
     */
    public function enableDebug(): void
    {
        $this->debug = true;
    }

    /**
     *
     */
    public function disableDebug(): void
    {
        $this->debug = false;
    }

    /**
     * @return bool
     */
    public function shouldUnmatchedBeKept(): bool
    {
        return $this->keepAllUnmatched;
    }

    /**
     * @param bool $keepAllUnmatched
     */
    public function setKeepAllUnmatched(bool $keepAllUnmatched): void
    {
        $this->keepAllUnmatched = $keepAllUnmatched;
    }

    /**
     * @param bool $fillMissingValues
     */
    public function setFillMissingValues(bool $fillMissingValues): void
    {
        $this->fillMissingValues = $fillMissingValues;
    }

    /**
     * @return bool
     */
    public function shouldMissingValuesBeFilled(): bool
    {
        return $this->fillMissingValues;
    }

    /**
     * @return bool
     */
    public function isOverrideAllowed(): bool
    {
        return $this->allowOverride;
    }

    /**
     * @param bool $allowOverride
     */
    public function setAllowOverride(bool $allowOverride): void
    {
        $this->allowOverride = $allowOverride;
    }

    /**
     * @return bool
     */
    public function warnOnDuplicateTranslations(): bool
    {
        return $this->warnOnDuplicateTranslations;
    }

    /**
     * @param bool $warnOnDuplicateTranslations
     */
    public function setWarnOnDuplicateTranslations(bool $warnOnDuplicateTranslations): void
    {
        $this->warnOnDuplicateTranslations = $warnOnDuplicateTranslations;
    }

    /**
     * @param string $to
     *
     * @return bool
     */
    public function hasTranslation(string $to): bool
    {
        return array_key_exists($to, $this->translations);
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public function getTranslations(string $key): array
    {
        return $this->translations[$key] ?? [];
    }

    /**
     *
     */
    private function reset(): void
    {
        $this->visited    = [];
        $this->attributes = [];
    }

    /**
     * @param string $key
     */
    private function markAsVisited(string $key): void
    {
        $this->visited[$this->getCurrentKey($key)] = true;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    private function wasVisited(string $key): bool
    {
        return array_key_exists($key, $this->visited);
    }

    /**
     * @param string        $key
     * @param callable      $callback
     * @param callable|null $constraint
     *
     * @return static
     */
    final public function map(string $key, callable $callback, callable $constraint = null): self
    {
        $this->callbacks[$key] = function (MapperInterface $mapper, $value) use ($callback, $constraint): void {
            if ($constraint === null || $constraint($value)) {
                $callback($mapper, $value);
            }
        };

        return $this;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @throws Exception
     */
    private function insertTranslation(string $from, string $to): void
    {
        if ($this->hasTranslation($to) && $this->warnOnDuplicateTranslations) {
            $translation = $this->getTranslations($to)[0];
            throw new Exception(sprintf('There is already a translation for %s with %s', $to, $translation));
        }

        $this->translations[$to][]   = $from;
        $this->translations[$from][] = $to;
    }

    /**
     * @param string        $from
     * @param string        $to
     * @param callable|null $constraint
     *
     * @return Mapper
     * @throws Exception
     */
    final public function translate(string $from, string $to, callable $constraint = null): self
    {
        $this->insertTranslation($from, $to);

        return $this->map($from, function (MapperInterface $mapper, $value) use ($to): void {
            $mapper->setAttribute($to, $value);
        }, $constraint);
    }

    /**
     * @param string        $key
     * @param callable|null $constraint
     *
     * @return Mapper
     */
    final public function keep(string $key, callable $constraint = null): self
    {
        return $this->map($key, function (MapperInterface $mapper, $value) use ($key): void {
            $mapper->setAttribute($key, $value);
        }, $constraint);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function getCurrentKey(string $key): string
    {
        $keys = [$key];
        foreach ($this->keys as $key) {
            $keys[] = $key;
        }

        return implode('.', array_reverse($keys));
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    private function hasCurrentCallback(string $key): bool
    {
        if ($this->debug) {
            var_dump($this->getCurrentKey($key));
        }

        return array_key_exists($this->getCurrentKey($key), $this->callbacks);
    }

    /**
     * @param string $key
     *
     * @return callable
     */
    private function getCurrentCallback(string $key): callable
    {
        return $this->callbacks[$this->getCurrentKey($key)];
    }

    /**
     * @param array $source
     *
     * @return array
     */
    final public function applyMapping(array $source): array
    {
        $this->reset();
        $this->executeMapping($source);

        if ($this->fillMissingValues) {
            $this->fillMissingValues();
        }

        return $this->attributes;
    }

    /**
     * @param array $source
     *
     * @return array
     */
    final public function applyMappingRecursive(array $source): array
    {
        return array_map(function (array $values): array {
            return $this->applyMapping($values);
        }, $source);
    }

    /**
     *
     */
    public function fillMissingValues(): void
    {
        foreach ($this->callbacks as $key => $callback) {
            if (!$this->wasVisited($key) && !$this->wasAtLeastOneTranslationVisisted($key)) {
                $callback($this, null);
            }
        }
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    private function wasAtLeastOneTranslationVisisted(string $key): bool
    {
        foreach ($this->getTranslations($key) as $from) {
            foreach ($this->getTranslations($from) as $to) {
                if ($this->wasVisited($to)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param array $source
     */
    private function executeMapping(array $source): void
    {
        foreach ($source as $key => $value) {
            if (is_array($value)) {
                $this->push($key, $value);
                $before = $this->keys->count();
                $this->executeMapping($value);
                $after = $this->keys->count();
                if ($before < $after) {
                    $this->pop();
                }
            }

            if ($this->hasCurrentCallback($key) && $this->canBeApplied($key)) {
                $this->applyCallback($key, $value);
                $this->markAsVisited($key);
            } elseif ($this->keepAllUnmatched) {
                $this->keep($this->getCurrentKey($key));
                $this->applyCallback($key, $value);
                $this->markAsVisited($key);
            }
        }

        $this->pop();
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    private function canBeApplied(string $key): bool
    {
        return $this->isOverrideAllowed() || !$this->wasAtLeastOneTranslationVisisted($key);
    }

    /**
     * @param string $key
     * @param        $value
     */
    private function push(string $key, $value): void
    {
        if (is_array($value)) {
            $this->keys->push($key);
            if ($this->debug) {
                print 'PUSH ' . $key . PHP_EOL;
            }
        }
    }

    /**
     *
     */
    private function pop(): void
    {
        if (!$this->keys->isEmpty()) {
            $key = $this->keys->pop();
            if ($this->debug) {
                print 'POP ' . $key . PHP_EOL;
            }
        }
    }

    /**
     * @param string $key
     * @param        $value
     */
    private function applyCallback(string $key, $value): void
    {
        $this->getCurrentCallback($key)($this, $value);
    }

    /**
     * @param array $keys
     * @param array $attributes
     * @param       $value
     */
    private function addEntry(array $keys, array &$attributes, $value): void
    {
        $count = count($keys);
        $key   = array_shift($keys);

        if ($count === 1) {
            $attributes[$key] = $value;
        } elseif ($count > 1) {
            $attributes[$key] = [];

            $this->addEntry($keys, $attributes[$key], $value);
        }
    }

    /**
     * @param string $category
     * @param        $value
     */
    final public function setAttribute(string $category, $value): void
    {
        $keys  = explode('.', $category);
        $attrs = [];
        $this->addEntry($keys, $attrs, $value);

        $this->merge($attrs);
    }

    /**
     * @param array $attributes
     */
    final public function merge(array $attributes): void
    {
        $this->attributes = self::mergeRecursiveDistinct($this->attributes, $attributes);
    }

    /**
     * @param array $array1
     * @param array $array2
     *
     * @return array
     */
    private static function mergeRecursiveDistinct(array &$array1, array &$array2): array
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged [$key]) && is_array($merged[$key])) {
                $merged[$key] = self::mergeRecursiveDistinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }
}
