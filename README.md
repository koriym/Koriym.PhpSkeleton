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
* [ComposerRequireChecker](https://github.com/maglnet/ComposerRequireChecker) Check composer dependencies.

## Project Structure

After installation, your project will have the following structure:

```
your-project/
├── src/                 # Source code
├── tests/               # Test files
│   └── Fake/            # Test doubles
├── vendor/              # Dependencies
├── vendor-bin/          # Development tool dependencies
├── build/               # Build artifacts (coverage reports, etc.)
├── composer.json        # Project configuration
├── phpcs.xml            # PHP_CodeSniffer configuration
├── phpmd.xml            # PHPMD configuration
├── phpstan.neon         # PHPStan configuration
├── phpunit.xml.dist     # PHPUnit configuration
├── psalm.xml            # Psalm configuration
├── composer-require-checker.json  # Composer dependencies checker configuration
└── README.md            # Project documentation
```

## Create Project

To create your project, enter the following command in your console:

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

Once installed, the project will automatically be configured, so you can run these commands in the root of your application:

### test

`composer test` runs [`phpunit`](https://github.com/sebastianbergmann/phpunit).

### tests

`composer tests` runs `cs`, `sa`, and `test`.

### coverage, phpdbg, pcov

`composer coverage` builds a test coverage report using [XDebug](https://xdebug.org/).
`composer phpdbg` builds a test coverage report using [phpdbg](https://www.php.net/manual/en/book.phpdbg.php).
`composer pcov` builds a test coverage report using [pcov](https://github.com/krakjoe/pcov).

### cs, cs-fix

`composer cs` checks coding standard.
`composer cs-fix` fixes the PHP code to match coding standards.

### sa

`composer sa` runs static code analysis tools (PHPStan and Psalm).

### metrics

`composer metrics` generates code quality [metrics](https://www.phpmetrics.org).

### build

`composer build` builds all reports (code quality, test coverage, require check, metrics).

## Continuous Integration

This project includes several GitHub Actions workflows to ensure code quality and compatibility. These workflows are pre-configured for common PHP project needs, but feel free to modify or remove them to suit your project's requirements.

