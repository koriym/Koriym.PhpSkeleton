PHP.ProjectSkeleton
=======
A standard PHP project skeleton
---------------------------------------------
This project was created in order to provide project skeleton to start new PHP projet.

Requiment
---------
 * PHP 5.2+

Setup
==============

Here's how to install to be CI ready.

    $ sudo pear channel-discover pear.pdepend.org
    $ sudo pear channel-discover pear.phpmd.org
    $ sudo pear channel-discover pear.phpunit.de
    $ sudo pear channel-discover components.ez.no
    $ sudo pear channel-discover pear.symfony-project.com
    
    $ sudo pear install pdepend/PHP_Depend
    $ sudo pear install phpmd/PHP_PMD
    $ sudo pear install phpunit/phpcpd
    $ sudo pear install phpunit/phploc
    $ sudo pear install PHPDocumentor
    $ sudo pear install PHP_CodeSniffer
    $ sudo pear install -a phpunit/PHP_CodeBrowser
    $ sudo pear install -a phpunit/PHPUnit

Testing PHP.ProjectSkeleton
==============

Here's how to install PHP.SkelietonProject from source to run the unit tests and ant.

    $ git clone https://github.com/koriym/PHP.SkeletonProject
    $ cd PHP.SkelietonProject
    $ git submodule update --init
    $ phpunit
    $ ant

Getting started
===============

 * Download PHP.SkeletonProject, unzip.
 * Rename _PHP.SkeletonProject_ to _your project folder name_
 * Rename _PHP.Skeleton_ to _your project name_ in files.
 * Rename _PHP\Skeleton_ to _your namespace_ in files.
 * Modify this README.
