# CHANGELOG

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org).

## [Unreleased]

No notable changes.

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
* `Rayne\wz2008\Graph\Parser\CompleteClassificationXmlFile.php` in favor of
  `Rayne\wz2008\Graph\Factory\WzClassificationFactory`

## 1.0.0-rc1 - 2017-02-05

Initial release.

[Unreleased]: https://github.com/Rayne/wz2008-graph/compare/1.0.0-rc2...HEAD
[1.0.0]: https://github.com/Rayne/wz2008-graph/compare/1.0.0-rc2...1.0.0
[1.0.0-rc2]: https://github.com/Rayne/wz2008-graph/compare/1.0.0-rc1...1.0.0-rc2
