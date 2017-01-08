# apparat/kernel

[![Build Status](https://secure.travis-ci.org/apparat/kernel.svg)](https://travis-ci.org/apparat/kernel)
[![Coverage Status](https://coveralls.io/repos/apparat/kernel/badge.svg?branch=master&service=github)](https://coveralls.io/github/apparat/kernel?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/apparat/kernel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/apparat/kernel/?branch=master)
[![Code Climate](https://codeclimate.com/github/apparat/kernel/badges/gpa.svg)](https://codeclimate.com/github/apparat/kernel)
[![Documentation Status](https://readthedocs.org/projects/apparat-kernel/badge/?version=latest)](http://apparat-kernel.readthedocs.io/en/latest/?badge=latest)

Provides common base functionality for all other apparat modules:

* Manifest module definition
* Environment variable support & validation (based on [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv))
* Dependency Injection / Inversion of Control (IoC) container (based on [level-2/dice](https://github.com/level-2/dice))
* [PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md) compatible logging (based on [monolog/monolog](https://github.com/Seldaek/monolog))
* TODO: Signals & Slots implementation

## Documentation

Please find the [project documentation](doc/index.md) in the `doc` directory. I recommend [reading it](http://apparat-kernel.readthedocs.io/) via *Read the Docs*.

## Installation

This library requires PHP 5.6 or later. I recommend using the latest available version of PHP as a matter of principle. It has no userland dependencies.

## Dependencies

![Composer dependency graph](https://rawgit.com/apparat/kernel/master/doc/dependencies.svg)

## Quality

To run the unit tests at the command line, issue `composer install` and then `phpunit` at the package root. This requires [Composer](http://getcomposer.org/) to be available as `composer`, and [PHPUnit](http://phpunit.de/manual/) to be available as `phpunit`.

This library attempts to comply with [PSR-1][], [PSR-2][], and [PSR-4][]. If you notice compliance oversights, please send a patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
