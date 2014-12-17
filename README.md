# PHP.Skeleton

## A standard PHP project skeleton

This project was created in order to provide project skeleton to start new PHP project.
Various config files are ready for continuous integration.

 * phpunit.xml for [phpunit](http://phpunit.de/manual/current/en/index.html)
 * build.xml for [Apache Ant](http://ant.apache.org/) / [Jenkins](http://jenkins-ci.org/)
 * .travis.yml for [Travis CI](https://travis-ci.org/)
 * .php_cs for [php-cs-fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)
 * .scrutinizer for [scrutinizer-ci](https://scrutinizer-ci.com/)
 
## Requirements

 * PHP 5.3+

## Getting started

### Create project

    $ composer create-project php/skeleton@dev {Vendor.Package}
    $ cd {Vendor.Package}
    $ composer dump-autoload
    $ phpunit


## CI - Using ant

### Install

Linux - [Installing Apache Ant](http://ant.apache.org/manual/install.html)

OSX

    $ port install apache-ant // by mac ports
    $ brew install ant // by brew

Windows - https://code.google.com/p/winant/
 
### Prepare

#### Install QA(Quality Assurance) tools
    $ ant require

#### Export composer bin path 

    export PATH="$HOME/.composer/vendor/bin:$PATH"

### Run
 
    $ ant test    // run test
    $ ant report  // output API and QA docs

    $ ant         // all (require, test, report)
