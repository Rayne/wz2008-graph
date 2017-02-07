# CHANGELOG

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org).

## [Unreleased]

### Added

* `InvalidParentException`

### Changed

* Renamed `Item` to `WzItem`
* Renamed `ItemInterface` to `WzItemInterface`
* Renamed `ItemManager` to `WzItemCollection`
* Renamed `ItemManagerInterface` to `WzItemCollectionInterface`
* Renamed `CompleteClassificationXml` to `WzClassification`
* Renamed `CompleteClassificationXmlFile` to `WzClassificationFile`
* `WzItemInterface` objects add themselves as children to their parents
* `WzItemInterface` parents verify if they are the parent of their children

## 1.0.0-rc1 - 2017-02-05

Initial release.

[Unreleased]: https://github.com/Rayne/wz2008-graph/compare/1.0.0-rc1...HEAD