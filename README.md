# PHP.Skeleton

## A standard PHP project skeleton

This project was created in order to provide project skeleton to start new PHP project.
Various config files are ready for continuous integration.

 * phpunit.xml for [phpunit](http://phpunit.de/manual/current/en/index.html)
 * .travis.yml for [Travis CI](https://travis-ci.org/)
 * .php_cs for [php-cs-fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)
 * .scrutinizer for [scrutinizer-ci](https://scrutinizer-ci.com/)
 
## Requirements

 * PHP 5.3+

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

`composer test` run `phpcs`, `phpmd` and `phpunit`

```
composer test
```

## build

`composer build` run `apigen`, `phploc`, `pdepend` and `test` above. It's handy for Jenkins. 

```
composer build
```
# Global installation of QA tools

```
composer global require bear/qatool

```
add this directory to your PATH in your ~/.bash_profile (or ~/.bashrc) like this:

```
export PATH=./vendor/bin:~/.composer/vendor/bin:$PATH
```
