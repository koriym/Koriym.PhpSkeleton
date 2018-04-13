# A standard PHP project skeleton

This project was created in order to provide project skeleton to start new PHP project.
Various config files are ready for continuous integration.
 
## Create Project
   
    
```
composer create-project koriym/php-skeleton {project-path}

What is the vendor name ?

(MyVendor):Koriym

What is the package name ?

(MyPackage):AwesomePackage.

What is your name ?

(Akihito Koriyama):
```

## Composer Commands

### test

`composer test` run [`phpunit`](https://github.com/sebastianbergmann/phpunit).

### tests

`composer tests` run [`phpcs`](https://github.com/squizlabs/PHP_CodeSniffer), [`php-cs-fixer`](https://github.com/FriendsOfPHP/PHP-CS-Fixer), [`phpmd`](https://github.com/phpmd/phpmd), [`phpstan`](https://github.com/phpstan/phpstan) and [`phpunit`](https://github.com/sebastianbergmann/phpunit). 

### coverage

`composer coverage` builds test coverage report.

### cs-fix

`composer cs-fix` run [`php-cs-fixer`](https://github.com/FriendsOfPHP/PHP-CS-Fixer) and [`phpcbf`](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Fixing-Errors-Automatically) to fix up the PHP code to follow the coding standards. (Check only command `compposer cs` is also available.)


### build

`composer build` run [`phploc`](https://github.com/sebastianbergmann/phploc), [`pdepend`](https://pdepend.org/) and [tests](#tests) above. It's handy for Jenkins. 
You need "composer require phploc/phploc pdepend/pdepend --dev" for this.
