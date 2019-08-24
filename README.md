# Rayne/wz2008-graph

`Rayne/wz2008-graph` parses the "Classification of Economic Activities"
issued by the Statistisches Bundesamt.
It builds multiple hierarchically structured
and object oriented in-memory trees
from flat file structures with implicit hierarchy.

[![Latest Stable Version](https://poser.pugx.org/rayne/wz2008-graph/v/stable)](https://packagist.org/packages/rayne/wz2008-graph)
[![Latest Unstable Version](https://poser.pugx.org/rayne/wz2008-graph/v/unstable)](https://packagist.org/packages/rayne/wz2008-graph)
[![Build Status](https://travis-ci.org/Rayne/wz2008-graph.svg?branch=master)](https://travis-ci.org/Rayne/wz2008-graph)
[![Code Coverage](https://scrutinizer-ci.com/g/rayne/wz2008-graph/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/rayne/wz2008-graph/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rayne/wz2008-graph/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rayne/wz2008-graph/?branch=master)
[![License](https://poser.pugx.org/rayne/wz2008-graph/license)](https://packagist.org/packages/rayne/wz2008-graph)

![Rayne/wz2008-graph builds a tree structure](./assets/cover-image.png "Rayne/wz2008-graph builds a tree structure")

## Contents

- [Paketbeschreibung](#paketbeschreibung-german)
- [Dependencies](#dependencies)
  - [Production](#production)
  - [Development](#development)
- [Licence](#licence)
- [Setup](#setup)
- [Benchmarks](#benchmarks)
- [Tests](#tests)
- [Usage](#usage)
  - [Search WzItem by ID](#search-wzitem-by-id)
  - [Traverse WzItems](#traverse-wzitems)
  - [Traverse Parents](#traverse-parents)
  - [Traverse Children](#traverse-children)
  - [Filter WzItems by Level](#filter-wzitems-by-level)
  - [Get translated Labels](#get-translated-labels)
  - [Get WzItem ID](#get-wzitem-id)
  - [Get WzItem Level](#get-wzitem-level)
- [Custom Data Sets](#custom-data-sets)

## Paketbeschreibung (German)

Diese Bibliothek extrahiert die implizit vorliegende hierarchische Branchen-Struktur
aus der *Klassifikation der Wirtschaftszweige, Ausgabe 2008 (WZ 2008)*.
Als Daten-Grundlage wird die vollständige Klassifikation als XML-Datei genutzt.

Die jeweils neuste Version liegt der Bibliothek bei.
Bei Bedarf kann auch eine eigene Version geladen werden.

> Die Klassifikation der Wirtschaftszweige, Ausgabe 2008 (WZ 2008), wurde unter intensiver Beteiligung von Datennutzern und Datenproduzenten in Verwaltung, Wirtschaft, Forschung und Gesellschaft geschaffen und dient dazu, die wirtschaftlichen Tätigkeiten von Unternehmen, Betrieben und anderen statistischen Einheiten in allen amtlichen Statistiken einheitlich zu erfassen. Sie berücksichtigt die Vorgaben der statistischen Systematik der Wirtschaftszweige in der Europäischen Gemeinschaft (NACE Rev. 2), die mit der Verordnung (EG) Nr. 1893/2006 des Europäischen Parlaments und des Rates vom 20. Dezember 2006 (ABl. EG Nr. L 393 S. 1) veröffentlicht wurde und auf der International Standard Industrial Classification (ISIC Rev. 4) der Vereinten Nationen basiert. Die Zustimmung der Europäischen Kommission gemäß Artikel 4, Absatz 3, der oben genannten Verordnung liegt vor. 
>
> Die Anwendung der WZ 2008 für statistische Zwecke ergibt sich aus Artikel 8 der oben genannten Verordnung. Danach sind Statistiken, die sich auf vom 1. Januar 2008 an durchgeführte Wirtschaftstätigkeiten beziehen (Berichtsperiode), auf der Grundlage der NACE Rev. 2 (in Deutschland auf der Grundlage der WZ 2008) zu erstellen. Abweichend hiervon sind Konjunkturstatistiken gemäß der Verordnung (EG) Nr. 1165/98 und der Arbeitskostenindex gemäß der Verordnung (EG) Nr. 450/2003 ab dem 1. Januar 2009 auf Basis der NACE Rev. 2 (in Deutschland auf Basis der WZ 2008) zu erstellen. Die Anwendung ab 2008/2009 gilt nicht für folgende Statistiken: Statistiken der Volkswirtschaftlichen Gesamtrechnungen gemäß der Verordnung (EG) Nr. 2223/96, die Landwirtschaftliche Gesamtrechnung gemäß der Verordnung (EG) Nr. 138/2004 und Statistiken der Zahlungsbilanz, des internationalen Dienstleistungsverkehrs und der Direktinvestitionen gemäß der Verordnung (EG) Nr. 184/2005. Diese Statistiken wenden die NACE Rev. 2 / WZ 2008 ab einem späteren Zeitpunkt an.
>
> Quelle: https://www.klassifikationsserver.de/klassService/index.jsp?variant=wz2008

## Dependencies

### Production

* PHP 5.6 or better

### Development

* Composer
* Git
* PHPUnit

## Licence

* The library is published under the [MIT licence](LICENSE).

* The shipped `/assets/WZ2008-[…].xml` file is intellectual property of the
  *Statistisches Bundesamt (Federal Statistical Office), Wiesbaden, Section „Classifications“*.

  ```
  File content: Classification (complete)
  Further information: https://www.klassifikationsserver.de/
  Copyright: © Statistisches Bundesamt, Wiesbaden 2008 Distribution (also in parts) permitted, provided that the source is mentioned.
  Owner: Issued by: Statistisches Bundesamt (Federal Statistical Office), Wiesbaden, Section „Classifications“, Phone.: 0611/75-2510, -2294, -2280, Fax: 0611/75-3953,  E-Mail: wz@destatis.de
  Type: 'ex' = Part of (see help of the classification server)
  ```

## Setup

[Download Composer](https://getcomposer.org/download) and install `rayne/wz2008-graph`.

```bash
composer require rayne/wz2008-graph
```

*Alternatives*

* Clone the repository (see the [Tests](#tests) chapter)
* Download a [zipped release](https://github.com/Rayne/wz2008-graph/releases)

## Benchmarks

It is recommended to call the `phpbench` program directly
instead of using the provided `composer bench` script.
The latter will kill the benchmark after five minutes.

```bash
./vendor/bin/phpbench run
```

## Tests

1.  Clone the repository

    ```bash
    git clone https://github.com/rayne/wz2008-graph.git
    ```

2.  Install the development dependencies

    ```bash
    composer install --dev --prefer-dist
    ```

3.  Run the tests

    ```bash
    composer test
    ```

## Usage

```php
use Rayne\wz2008\Graph\Factory\WzClassificationFactory;
use Rayne\wz2008\Graph\WzClassificationInterface;

/**
 * @var WzClassificationInterface $classification
 */

// Load the library's classification file …
$classification = WzClassificationFactory::build();

// … or load a custom classification file.
$classification = WzClassificationFactory::buildFromFile(
    'WZ2008-2016-07-29-Classification_(complete).xml');
```

### Search WzItem by ID

```php
use Rayne\wz2008\Graph\WzClassificationInterface;
use Rayne\wz2008\Graph\WzItemInterface;

/**
 * @var WzClassificationInterface $classification
 * @var WzItemInterface $item
 */

$id = '26.20.0';

if ($classification->has($id)) {
    $item = $classification->get($id);
}
```

### Traverse WzItems

It's possible to traverse parents and children
relative to a given `WzItemInterface` object.
Every item has a hierarchy level between `1` and `5`.
`WzItemInterface` provides the following human readable constants.

| DE          | EN       | Level | Constant                          |
|-------------|----------|-------|-----------------------------------|
| Abschnitt   | Section  | 1     | `WzItemInterface::LEVEL_SECTION`  |
| Abteilung   | Division | 2     | `WzItemInterface::LEVEL_DIVISION` |
| Gruppe      | Group    | 3     | `WzItemInterface::LEVEL_GROUP`    |
| Klasse      | Class    | 4     | `WzItemInterface::LEVEL_CLASS`    |
| Unterklasse | Subclass | 5     | `WzItemInterface::LEVEL_SUBCLASS` |

#### Traverse Parents

Fetch the direct parent or traverse one level up.

```php
use Rayne\wz2008\Graph\WzItemInterface;

/**
 * @var WzItemInterface $item
 * @var WzItemInterface|null $parent
 */

$parent = $item->getParent();
```

Fetch the parent on a specific level or move up to a specific level.

```php
use Rayne\wz2008\Graph\WzItemInterface;

/**
 * @var WzItemInterface $item
 * @var WzItemInterface|null $parent
 */

$parent = $item->getParentByLevel($item::LEVEL_SECTION);
```

#### Traverse Children

Fetch all direct children.

```php
use Rayne\wz2008\Graph\WzItemInterface;

/**
 * @var WzItemInterface $item
 * @var WzItemInterface[] $children
 */

$children = $item->getChildren();
```

Fetch all children by a specific level.
Children on other levels are skipped.

```php
use Rayne\wz2008\Graph\WzItemInterface;

/**
 * @var WzItemInterface $item
 * @var WzItemInterface[] $children
 */

$children = $item->getChildrenByLevel($item::LEVEL_CLASS);
```

## Filter WzItems by Level

Get all `WzItemInterface` items with a specific level.

```php
use Rayne\wz2008\Graph\WzClassificationInterface;
use Rayne\wz2008\Graph\WzItemInterface;

/**
 * @var WzClassificationInterface $classification 
 * @var WzItemInterface[] $sections
 */

$sections = $classification->getItemsByLevel(WzItemInterface::LEVEL_SECTION);
```

## Get translated Labels

`WzItemInterface` throws an `InvalidArgumentException`
when there isn't a translation for the given language code.
The official XML files are limited to `DE` and `EN`.

The `$langCode` of `WzItemInterface->getLabel($langCode)` is case-insensitive.

```php
use Rayne\wz2008\Graph\WzItemInterface;

/**
 * @var WzItemInterface $item
 * @var string $label
 */

$label = $item->getLabel('de');
```

Get all translated labels and their language codes.

```php
use Rayne\wz2008\Graph\WzItemInterface;

/**
 * @var WzItemInterface $item
 * @var string[] $labels
 */

$labels = $item->getLabels();
```

`WzItemInterface->getLabels()` returns simple
key (language code)
value (translated label)
maps.

```php
$labels = [
    'de' => 'Wirtschafts- und Arbeitgeberverbände',
    'en' => 'Activities of business and employers membership organisations',
];
```

### Get WzItem ID

```php
use Rayne\wz2008\Graph\WzItemInterface;

/**
 * @var WzItemInterface $item
 */

$item->getId();
```

### Get WzItem Level

```php
use Rayne\wz2008\Graph\WzItemInterface;

/**
 * @var WzItemInterface $item
 */

$item->getLevel();
```

## Custom Data Sets

1.  Download a `WZ2008-20XX-XX-XX-Classification_(complete).xml` file

    1.  Visit [klassifikationsserver.de/klassService/index.jsp?variant=wz2008](https://klassifikationsserver.de/klassService/index.jsp?variant=wz2008)

    2.  Locate the `ZIP` download in the download matrix at position

        ```
        ("Klassifikation komplett", "XML (Claset)")
        ```

    3. Extract the downloaded `ZIP` file

2.  Use the factory to build a `WzClassificationInterface` object
    based upon the downloaded XML file

    ```php
    use Rayne\wz2008\Graph\Factory\WzClassificationFactory;
    use Rayne\wz2008\Graph\WzClassificationInterface;

    /**
    * @var WzClassificationInterface $classification
    */

    $classification = WzClassificationFactory::buildFromFile(
        'WZ2008-2016-07-29-Classification_(complete).xml');
    ```
