<?php

namespace Demv\Mapper;

/**
 * Class KundeMapper
 *
 * @package Demv\Mapper
 */
final class KundeMapper extends AbstractMapper
{
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
     * Berufsdaten
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
    public function berufsdaten(string $sink, string $source = null, callable $callback = null): self
    {
        return $this->mapAttribute([__FUNCTION__, $sink], $source, $callback);
    }

    /**
     * Überträgt einen Wert von dem Quell-Array zum Ziel-Array für die Kategorie
     * Adressen
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
    public function adressen(string $sink, string $source = null, callable $callback = null): self
    {
        return $this->mapAttribute([__FUNCTION__, $sink], $source, $callback);
    }

    /**
     * Überträgt einen Wert von dem Quell-Array zum Ziel-Array für die Kategorie
     * Assets
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
    public function assets(string $sink, string $source = null, callable $callback = null): self
    {
        return $this->mapAttribute([__FUNCTION__, $sink], $source, $callback);
    }

    /**
     * Überträgt einen Wert von dem Quell-Array zum Ziel-Array für die Kategorie
     * Bankdaten
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
    public function bankdaten(string $sink, string $source = null, callable $callback = null): self
    {
        return $this->mapAttribute([__FUNCTION__, $sink], $source, $callback);
    }

    /**
     * Überträgt einen Wert von dem Quell-Array zum Ziel-Array für die Kategorie
     * Beziehung
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
    public function beziehung(string $sink, string $source = null, callable $callback = null): self
    {
        return $this->mapAttribute([__FUNCTION__, $sink], $source, $callback);
    }

    /**
     * Überträgt einen Wert von dem Quell-Array zum Ziel-Array für die Kategorie
     * Finanzen
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
    public function finanzen(string $sink, string $source = null, callable $callback = null): self
    {
        return $this->mapAttribute([__FUNCTION__, $sink], $source, $callback);
    }

    /**
     * Überträgt einen Wert von dem Quell-Array zum Ziel-Array für die Kategorie
     * Haushalt
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
    public function haushalt(string $sink, string $source = null, callable $callback = null): self
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

    /**
     * Überträgt einen Wert von dem Quell-Array zum Ziel-Array für die Kategorie
     * Risiken
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
    public function risiken(string $sink, string $source = null, callable $callback = null): self
    {
        return $this->mapAttribute([__FUNCTION__, $sink], $source, $callback);
    }
}
