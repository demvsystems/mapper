<?php

namespace Demv\Mapper;

/**
 * Class MaklerMapper
 *
 * @package Demv\Mapper
 */
final class MaklerMapper extends AbstractMapper
{
    /**
     * Überträgt einen Wert von dem Quell-Array zum Ziel-Array für die Kategorie
     * Adresse
     *
     * @param string   $sink     Das Ziel-Attribut, dass beschrieben wird
     * @param string   $source   Optional: Das Quell-Attribut, dass übertragen
     *                           wird. Wenn es nicht gesetzt ist, wird der Wert
     *                           von $sink genommen
     * @param callable $callback Optional: Ein Funktion, die eine Regel definiert
     *                           wie die $sink zu setzen ist. Ist keine Funktion
     *                           gegeben wird die $source immer übernommen
     *                           dem Wert aus der $sink gesetzt
     *
     * @return self
     */
    public function adresse(string $sink, string $source = null, callable $callback = null): self
    {
        return $this->mapAttribute([__FUNCTION__, $sink], $source, $callback);
    }

    /**
     * Überträgt einen Wert von dem Quell-Array zum Ziel-Array für die Kategorie
     * Firma
     *
     * @param string   $sink     Das Ziel-Attribut, dass beschrieben wird
     * @param string   $source   Optional: Das Quell-Attribut, dass übertragen
     *                           wird. Wenn es nicht gesetzt ist, wird der Wert
     *                           von $sink genommen
     * @param callable $callback Optional: Ein Funktion, die eine Regel definiert
     *                           wie die $sink zu setzen ist. Ist keine Funktion
     *                           gegeben wird die $source immer übernommen
     *                           dem Wert aus der $sink gesetzt
     *
     * @return self
     */
    public function firma(string $sink, string $source = null, callable $callback = null): self
    {
        return $this->mapAttribute([__FUNCTION__, $sink], $source, $callback);
    }

    /**
     * Überträgt einen Wert von dem Quell-Array zum Ziel-Array für die Kategorie
     * Grunddaten
     *
     * @param string   $sink     Das Ziel-Attribut, dass beschrieben wird
     * @param string   $source   Optional: Das Quell-Attribut, dass übertragen
     *                           wird. Wenn es nicht gesetzt ist, wird der Wert
     *                           von $sink genommen
     * @param callable $callback Optional: Ein Funktion, die eine Regel definiert
     *                           wie die $sink zu setzen ist. Ist keine Funktion
     *                           gegeben wird die $source immer übernommen
     *                           dem Wert aus der $sink gesetzt
     *
     * @return self
     */
    public function grunddaten(string $sink, string $source = null, callable $callback = null): self
    {
        return $this->mapAttribute([__FUNCTION__, $sink], $source, $callback);
    }

    /**
     * Überträgt einen Wert von dem Quell-Array zum Ziel-Array für die Kategorie
     * Kontakt
     *
     * @param string   $sink     Das Ziel-Attribut, dass beschrieben wird
     * @param string   $source   Optional: Das Quell-Attribut, dass übertragen
     *                           wird. Wenn es nicht gesetzt ist, wird der Wert
     *                           von $sink genommen
     * @param callable $callback Optional: Ein Funktion, die eine Regel definiert
     *                           wie die $sink zu setzen ist. Ist keine Funktion
     *                           gegeben wird die $source immer übernommen
     *                           dem Wert aus der $sink gesetzt
     *
     * @return self
     */
    public function kontakt(string $sink, string $source = null, callable $callback = null): self
    {
        return $this->mapAttribute([__FUNCTION__, $sink], $source, $callback);
    }
}
