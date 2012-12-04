PHP.ProjectSkelton
=======
CI ready PHP project skelton
---------------------------------------------
This project was created in order to provide project skelton to start new PHP projet.

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

Testing PHP.ProjectSkelton
==============

Here's how to install PHP.SkeltonProject from source to run the unit tests and ant.

    $ git clone https://github.com/koriym/PHP.SkeltonProject
    $ cd PHP.SkeltonProject
    $ git submodule update --init
    $ phpunit
    $ ant

Getting started
===============

 * Download PHP.SkeltonProject, unzip.
 * Rename _PHP.SkeltonProject_ to _your project folder name_
 * Rename _PHP.Skelton_ to _your project name_ in files.
 * Rename _PHP\Skelton_ to _your namespace_ in files.
 * Modify this README.
