# PHP.Skeleton

## A standard PHP project skeleton

This project was created in order to provide project skeleton to start new PHP project.
Various config files are ready for continuous integration.

 * phpunit.xml.dist for [phpunit](http://phpunit.de/manual/current/en/index.html)
 * phpmd.xml for [PHPMD](https://phpmd.org)
 * phpcs.xml for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer/wiki)
 * .php_cs for [php-cs-fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)
 * .travis.yml for [Travis CI](https://travis-ci.org/)
 * .scrutinizer for [scrutinizer-ci](https://scrutinizer-ci.com/)
 
## Requirements

 * PHP 5.4+

## Getting started

### Create project

    
```
composer create-project php/skeleton {project-path}

What is the vendor name ?

(MyVendor):Koriym

What is the package name ?

(MyPackage):AwesomeProject

What is your name ?

(Akihito Koriyama):
```

# Composer scripts

## test

`composer test` run [`phpcs`](https://github.com/squizlabs/PHP_CodeSniffer), [`phpmd`] (https://github.com/phpmd/phpmd) and [`phpunit`](https://github.com/sebastianbergmann/phpunit). Run `phpunit` for unit test only.

```
composer test
```

## cs-fix

`composer cs-fix` run [`php-cs-fixer`](https://github.com/FriendsOfPHP/PHP-CS-Fixer) and [`phpcbf`](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Fixing-Errors-Automatically) to fix up the PHP code to follow the coding standards.

```
composer cs-fix
```

## build

`composer build` run [`apigen`](https://github.com/apigen/apigen), [`phploc`](https://github.com/sebastianbergmann/phploc), [`pdepend`](https://pdepend.org/) and `test` above. It's handy for Jenkins. 

```
composer build
```
# Global installation of QA tools

```
composer global require bear/qatools

```
Add this directory to your PATH in your ~/.bash_profile (or ~/.bashrc) like this:

```
export PATH=./vendor/bin:~/.composer/vendor/bin:$PATH
```

See detail at [bear/qatools](https://github.com/bearsunday/BEAR.QATools).
