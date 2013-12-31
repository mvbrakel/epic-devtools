# EPIC Devtools

This repository holds tools used in development by team epic.

## Install

The "epic-devtools" are published to packagist. To use the tools, include them in your composer.json.

    "require": {
        "enrise/epic-devtools": "1.*",
    }


## Features

### EPIC created

-  **[dev]** Git PSR-2 pre-commit hook
    - Check compliance
    - Fix basics

### Externals

- [squizlabs/php_codesniffer](https://github.com/squizlabs/php_codesniffer)
- [fabpot/php-cs-fixer](https://github.com/fabpot/php-cs-fixer)


## Usage

Depending on which tools you are going to use, install/update composer with or without the ``` --dev ``` directive.
The features explain if you should or should not use ``` --dev ```.

### Installing specific tools

    $ vendor/bin/edt githooks::install [-f (force override of existing hooks)]
