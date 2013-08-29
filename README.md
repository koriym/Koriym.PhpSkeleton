PHP.Skeleton
=======
A standard PHP project skeleton
---------------------------------------------
This project was created in order to provide project skeleton to start new PHP project.
Various config files are ready for continuous integration.

 * phpunit.xml for [phpunit](http://phpunit.de/manual/current/en/index.html)
 * build.xml for [Apache Ant](http://ant.apache.org/) / [Jenkins](http://jenkins-ci.org/)
 * .travis.yml for [Travis CI](https://travis-ci.org/)

Requirements
------------
 * PHP 5.3+

Getting started
---------------

### Create project
```
 $ composer create-project php/skeleton {Vendor.Package}
 $ cd {Vendor.Package}
 $ composer dump-autoload
 $ phpunit
```


Using ant
---------

### Prepare

Install QA(Quality Assurance) tools
```bash
 $ ant require
```
Export composer bin path 
```bash
export PATH="$HOME/.composer/vendor/bin:$PATH"
```

## ant
```bash
 $ ant
 
 $ ant test
 $ ant report
```
