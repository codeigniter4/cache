# CodeIgniter 4 PSR Cache
PSR-6 and PSR-16 Cache Adapters for CodeIgniter 4 

[![](https://github.com/codeigniter4/cache/workflows/PHPUnit/badge.svg)](https://github.com/codeigniter4/cache/actions/workflows/phpunit.yml)
[![](https://github.com/codeigniter4/cache/workflows/PHPStan/badge.svg)](https://github.com/codeigniter4/cache/actions/workflows/phpstan.yml)
[![](https://github.com/codeigniter4/cache/workflows/Deptrac/badge.svg)](https://github.com/codeigniter4/cache/actions/workflows/deptrac.yml)
[![Coverage Status](https://coveralls.io/repos/github/codeigniter4/cache/badge.svg?branch=develop)](https://coveralls.io/github/codeigniter4/cache?branch=develop)

**Disclaimer: CodeIgniter 4 comes with a fully-functional cache component! This module
is only for integrating third-party packages that rely on the PSR interface provisions.**

## Quick Start

1. Install with Composer: `> composer require codeigniter4/cache`
2. Integrate with your favorite packages:
```
use CodeIgniter\Psr\Cache\SimeplCache;
use Kreait\Firebase\Factory;
...

$factory = (new Factory)->withVerifierCache(new SimpleCache());
```

## Features

A set of adapters fully-compliant with PSR-6 and PSR-16 to integrate with CodeIgniter 4's Caching Driver.

## Installation

Install easily via Composer to take advantage of CodeIgniter 4's autoloading capabilities
and always be up-to-date:
* `> composer require codeigniter4/cache`

Or, install manually by downloading the source files and adding the directory to
`app/Config/Autoload.php`.

## Usage

This module has adapters for CodeIgniter 4 to supply the following FIG PHP Standards Recommendations (PSR):
* [Caching Interface](https://www.php-fig.org/psr/psr-6)
* [Simple Cache](https://www.php-fig.org/psr/psr-16)

If you just need a caching agent then you should use the framework's native [Caching Driver](https://codeigniter4.github.io/CodeIgniter4/libraries/caching.html).
These adapters are intended to integrate with any library or project that requires either of the following:
* [psr/cache-implementation](https://packagist.org/packages/psr/cache/dependents?order_by=downloads)
* [psr/simple-cache-implementation](https://packagist.org/packages/psr/simple-cache/dependents?order_by=downloads)

The interfaces are provided by the following classes:
* `Psr\Cache\CacheItemInterface` provided by `CodeIgniter\Psr\Cache\Item`
* `Psr\Cache\CacheItemPoolInterface` provided by `CodeIgniter\Psr\Cache\Pool`
* `Psr\SimpleCache\CacheInterface` provided by `CodeIgniter\Psr\Cache\SimpleCache`

By default the adapters (`Pool` and `SimpleCache`) will work with the Caching Driver as defined
in you cache configuration (e.g. **app/Config/Cache.php**). You may create either driver explicitly
with an alternative Cache Handler or Config:
```
	$sharedCacheServicePool = new \CodeIgniter\Psr\Cache\Pool();

	$fileHandler = new \CodeIgniter\Cache\Handlers\FileHandler(config('Cache'));
	$explicitFileHandlerSimpleCache = new \CodeIgniter\Psr\Cache\SimpleCache($fileHandler);

	$config = config('Cache');
	$config->prefix = 'banana-';
	$alternativeConfigPool = new \CodeIgniter\Psr\Cache\Pool($config);
```

## Testing

Testing of the underlying Caching Driver is handled in the [CodeIgniter 4 repo](https://github.com/codeigniter4/CodeIgniter4/tree/develop/tests/system/Cache).
These adapters are tested with the [PHP Cache Integration Tests](https://github.com/php-cache/integration-tests), by Aaron Scherer.
You may run the test suite by cloning this repo, installing all dependencies, and running:
* `> composer test`
