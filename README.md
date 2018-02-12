# Mapper
Der Mapper ist dazu da, flexibel verschiedene Array-Formate in und vom Aggregations-Array-Format umzuwandeln. Durch die Umwandlung **in** das vorliegende Aggregations-Array-Format kann anschließend das Resultat direkt per Array-_Import_ als Kunde importiert werden.
Nach einem Export kann mithilfe des Mappers das resultierende Format in ein vorheriges, nicht notwendigerweise konformes Format geändert werden.
Die Funktionsweise ist sehr einfach & flexibel. Ein Beispiel:
```php
$mapper = new Mapper();
$mapper->map('Daten.Vor-Name', function(MapperInterface $mapper, $value) {
    $mapper->setAttribute('grunddaten.vorname', $value);
});
$mapper->map('Finanzen.Netto.Betrag', function(MapperInterface $mapper, $value) {
    $mapper->setAttribute('finanzen.netto', (int) $value > 0 ? $value : 0);
});
$result = $mapper->applyMapping(
    [
        'Daten' => [
            'Vor-Name' => 'Müller'
        ],
        'Finanzen' => [
            'Netto' => [
                'Betrag' => 1500
            ]
        ]
    ]
);
```

Mit der Methode `map` wird angegeben, dass wir den Key `Vor-Name` der im Unter-Array `Daten` steckt - also sich hier befindet: `['Daten']['Vor-Name']`) - in den Key `vorname` des Unterarray `grunddaten` des resultierenden Arrays schreiben möchten. Die Dot-Notation gibt dabei beliebig geschachtelte Array-Strukturen an. `$result` wäre daher
```
[
	'grunddaten' => [
		'vorname' => 'Müller'
	],
	'finanzen' => [
		'netto' => 1500
	]
]
```

Mit dem optionalen Callback können Die Werte vor dem schreiben verifiziert bzw. modifiziert werden.

Die nun vorliegende Struktur lässt sich auch wieder in die Ursprungs-Struktur zurück transformieren:

```php
$mapper = new Mapper();
$mapper->map('grunddaten.vorname', function(MapperInterface $mapper, $value) {
    $mapper->setAttribute('Daten.Vor-Name', $value);
});
$mapper->map('finanzen.netto', function(MapperInterface $mapper, $value) {
    $mapper->setAttribute('Finanzen.Netto.Betrag', $value);
});
$source = $mapper->applyMapping($result);
```

`$source` würde also wieder aussehen, wie die Eingangs-Struktur:
```
[
    'Daten' => [
        'Vor-Name' => 'Müller'
    ],
    'Finanzen' => [
        'Netto' => [
            'Betrag' => 1500
        ]
    ]
]
```

Da es in der Aggregation bereits fest definierte Strukturen gibt, existiert neben dem Mapper auch ein `KundenMapper` und ein `MaklerMapper`, der die entsprechenden Funktionalitäten, wie das grunddaten Mapping, bereits als Methode anbieten, in der man Ziel und Quelle in der Dot-Notation angibt:
```php
$mapper->grunddaten('vorname', 'Daten.Vor-Name');
```
Das Resultat von `applyMapping` wäre bei der Eingangs erwähnten Struktur wie folgt:
```
[
	'grunddaten' => [
		'vorname' => 'Müller'
	]
]
```
