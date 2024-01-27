# OpenSwoole IDE Helper

[![Latest Stable Version](https://img.shields.io/packagist/v/openswoole/ide-helper.svg)](https://packagist.org/packages/openswoole/ide-helper)
[![License](https://poser.pugx.org/openswoole/ide-helper/license)](LICENSE)
[![GitHub stars](https://img.shields.io/github/stars/openswoole/swoole-src)](https://github.com/openswoole/swoole-src/stargazers)
[![Twitter](https://img.shields.io/twitter/url/https/twitter.com/openswoole.svg?style=social&label=Follow%20%40OpenSwoole)](https://twitter.com/openswoole)


This package contains IDE help files for [OpenSwoole](https://openswoole.com). You may use it in your IDE to provide accurate autocompletion.

## Install

You can add this package to your project using [Composer](https://getcomposer.org):

```bash
# v22.x
composer require openswoole/ide-helper:~22.0.1
# v4.x
composer require openswoole/ide-helper:~4.11.6
```

It's better to install this package on only development systems by adding the `--dev` flag to your Composer commands:

```bash
# v22.x
composer require --dev openswoole/ide-helper:~22.0.1
# v4.x
composer require --dev openswoole/ide-helper:~4.11.6
```

## PHP Intelephense extension users

Make sure you have included the openswoole ide-helper in the includePaths:

```bash
"intelephense.environment.includePaths": [
  "vendor/openswoole/ide-helper"
]
```

## Fix code style before commit

```bash
./vendor/bin/php-cs-fixer fix
```

## Documentation

Documentation for Open Swoole can be found on the [Open Swoole website](https://openswoole.com/docs).
