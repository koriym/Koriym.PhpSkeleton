# A standard PHP project skeleton

Are you tired of copy-pasting your boilerplate PHP code whenever you need to start a new project?

This repository contains a single-line command that will automatically setup for you all the needed code to create a modern, clutter-free and test-oriented PHP package.

It will automatically install the following dependencies:

* [PHPUnit](https://phpunit.readthedocs.io/ja/latest/): provides testing framework.
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer/wiki): detects violations of a defined set of coding standards.
* [PHPMD](https://phpmd.org): analyze your code to detect sub-optimal or overly complex code.
* [PHPStan](https://phpmd.org): discover bugs in your code without running it.
* [Psalm](https://psalm.dev): - another static analysis tool from Vimeo.
* [PHPMetrics](https://www.phpmetrics.org) provides various metrics.

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

Once installed, the project will automatically be configured, so you can run those commands in the root of your application:

### test

`composer test` run [`phpunit`](https://github.com/sebastianbergmann/phpunit).

### tests

`composer tests` run `cs`, `sa`, and `test`.

### coverage, phpdbg, pcov

`composer coverage` builds test coverage report.  `coverage` use [XDebug](https://xdebug.org/), `phpdbg` use [phpdbg](https://www.php.net/manual/en/book.phpdbg.php). `pcov` use [pcov](https://github.com/krakjoe/pcov).
### cs, cs-fix

`composer cs` checks coding standard. `composer cs-fix` fix up the PHP code.

### sa

`composer sa` run static code analysis tools. (phpstan and psalm)

### metrics

`composer metrics` reports code [metrics](https://www.phpmetrics.org).

### build

`composer build` builds all reports.
