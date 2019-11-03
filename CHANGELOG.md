# CHANGELOG

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org).

## [Unreleased]

No notable changes.

## [1.1.5] - 2019-11-03

### Changed

* Updated the supplied classification file to version `WZ2008-2019-10-22`

## [1.1.4] - 2019-07-24

### Added

* Added `composer` scripts for running the benchmark,
  formatting the source code and testing the library

* Added `composer bench`, `composer format` and `composer test` shortcuts
  for running benchmarks, formatting source code and running tests

### Changed

* Updated the supplied classification file to version `WZ2008-2019-07-31`

## [1.1.3] - 2019-06-09

### Changed

* Updated the supplied classification file to version `WZ2008-2019-05-31`

## [1.1.2] - 2018-10-08

### Changed

* Updated the supplied classification file to version `WZ2008-2018-09-04`

## [1.1.1] - 2018-07-16

### Changed

* Updated the supplied classification file to version `WZ2008-2018-06-29`

## [1.1.0] - 2017-05-19

### Added

* Benchmarks

### Changed

* Updated the supplied classification file to version `WZ2008-2017-04-25`

## [1.0.1] - 2017-02-20

This patch release updates the tags of the
[`Packagist`](https://packagist.org/packages/rayne/wz2008-graph)
repository.

### Changed

* Updated `Composer` tags

## [1.0.0] - 2017-02-14

No notable changes.

## [1.0.0-rc2] - 2017-02-13

The release candidate introduces backward compatibility breaking changes
but also streamlines the API and removes feature creep.

### Added

* `Rayne\wz2008\Graph\Exception\InvalidParentException`
* `Rayne\wz2008\Graph\Factory\WzClassificationFactory`
* `Rayne\wz2008\Graph\Factory\WzClassificationFactory::build()`
  builds a `Rayne\wz2008\Graph\WzClassificationInterface` object
  based upon the supplied `/assets/WZ2008-[…].xml` file
* `Rayne\wz2008\Graph\WzClassification`
* `Rayne\wz2008\Graph\WzClassificationInterface`

### Changed

* It's no longer necessary to manually download the latest `wz2008` XML file
  as the library is now officially shipping the latest version.
  Call `WzClassificationFactory::build()` to receive an
  `WzClassificationInterface` object with the shipped data set
* Renamed `Item` to `WzItem`
* Renamed `ItemInterface` to `WzItemInterface`
* `WzItemInterface` objects add themselves as children to their parents
* `WzItemInterface` parents verify if they are the parent of their children

### Removed

* `Rayne\wz2008\Graph\ItemManager` in favor of
  `Rayne\wz2008\Graph\WzClassification`
* `Rayne\wz2008\Graph\ItemManagerInterface` in favor of
  `Rayne\wz2008\Graph\WzClassificationInterface`
* `Rayne\wz2008\Graph\Parser\CompleteClassificationXml` in favor of
  `Rayne\wz2008\Graph\Factory\WzClassificationFactory`
* `Rayne\wz2008\Graph\Parser\CompleteClassificationXmlFile` in favor of
  `Rayne\wz2008\Graph\Factory\WzClassificationFactory`

## 1.0.0-rc1 - 2017-02-05

Initial release.

[Unreleased]: https://github.com/Rayne/wz2008-graph/compare/1.1.5...HEAD
[1.1.5]: https://github.com/Rayne/wz2008-graph/compare/1.1.4...1.1.5
[1.1.4]: https://github.com/Rayne/wz2008-graph/compare/1.1.3...1.1.4
[1.1.3]: https://github.com/Rayne/wz2008-graph/compare/1.1.2...1.1.3
[1.1.2]: https://github.com/Rayne/wz2008-graph/compare/1.1.1...1.1.2
[1.1.1]: https://github.com/Rayne/wz2008-graph/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/Rayne/wz2008-graph/compare/1.0.1...1.1.0
[1.0.1]: https://github.com/Rayne/wz2008-graph/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/Rayne/wz2008-graph/compare/1.0.0-rc2...1.0.0
[1.0.0-rc2]: https://github.com/Rayne/wz2008-graph/compare/1.0.0-rc1...1.0.0-rc2
