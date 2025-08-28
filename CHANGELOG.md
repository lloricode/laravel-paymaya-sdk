# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## v3.1.0 - 2025-08-28

**Full Changelog**: https://github.com/lloricode/laravel-paymaya-sdk/compare/v3.0.0...v3.1.0

## v3.0.0 - 2025-08-25

### What's Changed

* Bump dependabot/fetch-metadata from 2.3.0 to 2.4.0 by @dependabot[bot] in https://github.com/lloricode/laravel-paymaya-sdk/pull/18
* Bump stefanzweifel/git-auto-commit-action from 5 to 6 by @dependabot[bot] in https://github.com/lloricode/laravel-paymaya-sdk/pull/20
* Bump aglipanci/laravel-pint-action from 2.5 to 2.6 by @dependabot[bot] in https://github.com/lloricode/laravel-paymaya-sdk/pull/21
* Bump actions/checkout from 4 to 5 by @dependabot[bot] in https://github.com/lloricode/laravel-paymaya-sdk/pull/22
* Saloon by @lloricode in https://github.com/lloricode/laravel-paymaya-sdk/pull/23

### New Contributors

* @lloricode made their first contribution in https://github.com/lloricode/laravel-paymaya-sdk/pull/23

**Full Changelog**: https://github.com/lloricode/laravel-paymaya-sdk/compare/v2.0.2...v3.0.0

## v2.0.2 - 2025-02-21

### What's Changed

* Add support for laravel 12
* Drop support laravel 10
* Bump dependabot/fetch-metadata from 1.6.0 to 2.0.0 by @dependabot in https://github.com/lloricode/laravel-paymaya-sdk/pull/11
* Bump aglipanci/laravel-pint-action from 2.3.1 to 2.4 by @dependabot in https://github.com/lloricode/laravel-paymaya-sdk/pull/12
* Bump dependabot/fetch-metadata from 2.0.0 to 2.1.0 by @dependabot in https://github.com/lloricode/laravel-paymaya-sdk/pull/13
* Bump dependabot/fetch-metadata from 2.1.0 to 2.2.0 by @dependabot in https://github.com/lloricode/laravel-paymaya-sdk/pull/14
* Bump dependabot/fetch-metadata from 2.2.0 to 2.3.0 by @dependabot in https://github.com/lloricode/laravel-paymaya-sdk/pull/16
* Bump codecov/codecov-action from 4 to 5 by @dependabot in https://github.com/lloricode/laravel-paymaya-sdk/pull/15
* Bump aglipanci/laravel-pint-action from 2.4 to 2.5 by @dependabot in https://github.com/lloricode/laravel-paymaya-sdk/pull/17

**Full Changelog**: https://github.com/lloricode/laravel-paymaya-sdk/compare/v2.0.1...v2.0.2

## v2.0.1 - 2024-03-05

### Added

- Nothing.

### Changed

- Add support for laravel 11

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## v2.0.0 - 2023-04-28

### Added

- Nothing.

### Changed

- Use `lloricode/paymaya-sdk-php`: ^2.0.0

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## v2.0.0-alpha.2 - 2023-02-21

### Added

- Add timeout.

### Changed

- Use `lloricode/paymaya-sdk-php`: ^2.0.0-alpha.2

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## v2.0.0-alpha - 2023-02-17

### Added

- Nothing.

### Changed

- Use `lloricode/paymaya-sdk-php`: ^2.0.0-alpha

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## v1.0.0 - 2023-02-16

### Added

- Add --ci on pest in GitHub action
  
- Install rector
  
- Install laravel pint
  

### Changed

- Use phpstan

### Deprecated

- Nothing.

### Removed

- Remove psalm

### Fixed

- Nothing.

## 0.4.0-alpha2 - 2022-04-18

### Added

- Add config ray for phpunit.
  
- Add test rows for consoles.
  
- Add support for laravel 9.
  

### Changed

- Use pestphp for testing.
  
- Set minimum to latest spatie laravel ray 1.24.2.
  
- Set minimum to latest lloricode/paymaya-sdk-php ^0.5.0-alpha4.
  

### Deprecated

- Nothing.

### Removed

- Remove phly/keep-a-changelog (require symfony 6).

### Fixed

- Nothing.

## 0.4.0-alpha1 - 2021-08-13

### Added

- Add composer-runtime-api:^2.0 in require --dev, to enforce use composer v2 in development.
  
- Add phly/keep-a-changelog in require --dev.
  

### Changed

- Set Minimum lloricode/paymaya-sdk-php:^v0.5.0-alpha3.
  
- Move todo from changelog to config file.
  
- Update changelog format.
  

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.4.0-alpha - 2021-05-17

### Added

- Nothing.

### Changed

- Use lloricode/paymaya-sdk-php 0.5.0-alpha.

### Deprecated

- Nothing.

### Removed

- Drop support for php 7.

### Fixed

- Nothing.

## 0.3.7 - 2021-03-18

### Added

- Nothing.

### Changed

- Enhance Paymaya Client call.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.3.6 - 2021-03-05

### Added

- Add delete customization command.

### Changed

- Set minimum version lloricode/paymaya-sdk-php ^0.4.2.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.3.5 - 2021-03-03

### Added

- Add missing facade alias.
  
- Add support for laravel ^7.0.
  

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.3.4 - 2021-03-01

### Added

- Nothing.

### Changed

- Fix test console expectsTable with minimum `laravel/framework:^8.22`,
  see [v8.22 changelog](https://github.com/laravel/framework/blob/8.x/CHANGELOG-8.x.md#v8220-2021-01-12)
  and [laravel PR #35820](https://github.com/laravel/framework/pull/35820)..
  
- Set minimum version lloricode/paymaya-sdk-php ^0.4.1.
  

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.3.3 - 2021-03-01

### Added

- Nothing.

### Changed

- Update readme.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.3.2 - 2021-03-01

### Added

- Nothing.

### Changed

- Handle customization validation error.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.3.1 - 2021-03-01

### Added

- Add customization register and retrieve command.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.3.0 - 2021-02-26

### Added

- Nothing.

### Changed

- Use and fix deprecate for lloricode/paymaya-sdk-php ^0.4.0.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.2.0 - 2021-02-23

### Added

- Add main facade manager.
  
- Add facade for webhook.
  

### Changed

- Fix deprecate for lloricode/paymaya-sdk-php ^0.3.0.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.1.2 - 2021-02-08

### Added

- Nothing.

### Changed

- Fix access config in production server.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.1.1 - 2021-02-08

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Remove url() in config.

### Fixed

- Nothing.

## 0.1.0 - 2021-02-08

### Added

- Initial release.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.
