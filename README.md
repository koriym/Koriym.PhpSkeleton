# A standard PHP project skeleton
[![Build Status](https://travis-ci.org/koriym/Koriym.PhpSkeleton.svg?branch=1.x)](https://travis-ci.org/koriym/Koriym.PhpSkeleton)

Are you tired of copy-pasting your boilerplate PHP code whenever you need to start a new project?

This repository contains a single-line command that will automatically setup for you all the needed code to create a modern, clutter-free and test-oriented PHP package.

It will automatically install the following dependencies:

* PHPUnit: run your unit tests.
* PHP_CodeSniffer: validate your code against code convention.
* PHP CS Fixer: automatically fix your code to match the code convention.
* PHPMD: analyze your code to detect sub-optimal or overly complex code.
* PHPStan: analyze your code without running it to find bugs even before you write tests for the code. 
* Psalm: another static analysis tool from Vimeo.

As well as config file for popular continuous integration tool.
 
## Create Project
   
To create your project, enter the following command in your console.    

```
composer create-project koriym/php-skeleton <project-path>
```

You will be asked a few questions to configure the project:

```
What is the vendor name ?

(MyVendor):Koriym

What is the package name ?

(MyPackage):AwesomePackage

What is your name ?

(Akihito Koriyama):

What is your email address ?

(akihito.koriyama@gmail.com):
```

## Composer Commands

Once installed, the project will automatically be configured so you can run those commands in the root of your application:

### test

`composer test` run [`phpunit`](https://github.com/sebastianbergmann/phpunit).

### tests

`composer tests` run [`phpcs`](https://github.com/squizlabs/PHP_CodeSniffer), [`php-cs-fixer`](https://github.com/FriendsOfPHP/PHP-CS-Fixer), [`phpmd`](https://github.com/phpmd/phpmd), [`phpstan`](https://github.com/phpstan/phpstan),[`psalm`](https://psalm.dev) and [`phpunit`](https://github.com/sebastianbergmann/phpunit). 

### coverage

`composer coverage` builds test coverage report.

### cs-fix

`composer cs-fix` run [`php-cs-fixer`](https://github.com/FriendsOfPHP/PHP-CS-Fixer) and [`phpcbf`](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Fixing-Errors-Automatically) to fix up the PHP code to follow the coding standards. (Check only command `compposer cs` is also available.)


## Setup continuous integration

 * [Travis CI](https://docs.travis-ci.com/user/getting-started)
 * [Scrutinizer](https://scrutinizer-ci.com/docs/)
