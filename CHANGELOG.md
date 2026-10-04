# Changelog

All notable changes to this project are documented in this file.

## [3.0.0] - 2026-10-04

### Changed

- Verified compatibility with PHP 8.5.11 while retaining PHP 8.3 as the minimum supported version.
- Changed `FileUtils::renderFileContent()` return type from `string` to `void` to match its output-only behavior.
- Added an explicit `void` return type to `FileUtils::deleteDir()`.
- Scoped Composer PSR-4 autoloading to the `WebSK\` namespace.

### Fixed

- Enabled Unicode mode when detecting Russian text in `Transliteration::checkRussian()`.

### Added

- Added PHPUnit 12.5 tests for file, date, URL, network, sanitization, message, and transliteration utilities.
- Added Composer scripts for tests and syntax checks.
- Added the MIT license.
