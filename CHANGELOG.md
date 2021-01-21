<!-- markdownlint-disable no-duplicate-header -->
# Changelog

## v1.1.0 [BETA] - Sunset Aloe (BETA) - 21st January, 2021

This version brings in a ton of new features after a month of extensive usage and better integration with Leaf MVC 3 (BETA).

### Added

- Added support for Leaf MVC
- Added auth scaffolding for session auth
- Updated stubs
- Added more informative exceptions
- Added `Aloe\Installer` package for super copying to project directory
- Added new commands

### Fixed

- Updated to symfony console 5
- Updated dependencies with security patches
- Command variables and methods are now private/protected to match symfony console

### Changed

- Made `Leaf\Auth` methods static. They can now be called from anywhere within your Leaf app.

### Removed

- Nothing was removed

## v1.0.0 - Harlana - 15th November, 2020

The very first of Aloe CLI. Just a heads up, there may be a few bugs, open an issue if you find any bugs, thanks.
