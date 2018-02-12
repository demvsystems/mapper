<?php

namespace Demv\Mapper;

/**
 * Class MapperInterface
 *
 * @package Demv\Mapper
 */
interface MapperInterface
{
    /**
     * Setzt das übergebene Sources Array am Sink Array.
     *
     * @param array $sources
     *
     * @return array sink
     */
    public function applyMapping(array $sources): array;

    /**
     * @param string $category
     * @param        $value
     */
    public function setAttribute(string $category, $value);

    /**
     * @param array $attributes
     */
    public function merge(array $attributes);
}
