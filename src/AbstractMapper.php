<?php

namespace Demv\Mapper;

/**
 * Class AbstractMapper
 *
 * @package Demv\Mapper
 */
abstract class AbstractMapper extends Mapper
{
    /**
     * @param array         $sinks
     * @param string        $source
     * @param callable|null $callback
     *
     * @return static
     */
    final protected function mapAttribute(array $sinks, string $source, callable $callback = null): self
    {
        $sink = implode('.', $sinks);

        return $this->map($source, function (MapperInterface $mapper, $value) use ($callback, $sink) {
            $value = $callback ? $callback($value) : $value;
            $mapper->setAttribute($sink, $value);
        });
    }

    /**
     * @param string        $sink
     * @param string        $source
     * @param callable|null $callback
     */
    final public function meta(string $sink, string $source, callable $callback = null)
    {
        $this->mapAttribute([__FUNCTION__, $sink], $source, $callback);
    }
}
