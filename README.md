# Candidate Task
[![Build Status](https://travis-ci.com/finchmeister/candidate-task.svg?branch=master)](https://travis-ci.com/finchmeister/candidate-task)
## Requirements
- PHP 7.2
- Composer

## Installation
```
composer install
```

## Usage

To obtain a report of all merchant transactions for a given merchant in GBP use:

```
bin/console app:merchant-transactions 1
```

## Tests
```
./bin/phpunit
```

## About

- Symfony 4 console application
- Original CSV as data source
- Static exchange rates
- Fully unit & integration tested with Travis integration