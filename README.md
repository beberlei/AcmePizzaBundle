Acme Pizza Bundle
=================

This is a test-bundle for the experimental form support.

It is very early status and will be finalized as a demo example over the weekend.

Distribution: Best used with [Symfony Standard Edition](https://github.com/symfony/symfony-standard)

Requirements
------------

Symfony(https://github.com/symfony/symfony) obviously.

Installation
------------

### Add the deps for the needed bundles

``` php
[AcmePizzaBundle]
    git=https://github.com/beberlei/AcmePizzaBundle.git
    target=/bundles/Acme/PizzaBundle

[doctrine-fixtures]
    git=http://github.com/doctrine/data-fixtures.git

[DoctrineFixturesBundle]
    git=http://github.com/symfony/DoctrineFixturesBundle.git
    target=/bundles/Symfony/Bundle/DoctrineFixturesBundle
```
Next, run the vendors script to download the bundles:

``` bash
$ php bin/vendors install
```

### Add to autoload.php

``` php
$loader->registerNamespaces(array(
    'Acme'             => __DIR__.'/../vendor/bundles',
    // ...
```

### Register AcmePizzaBundle to Kernel

``` php
<?php

    # app/AppKernel.php
    //...
    $bundles = array(
        //...
        new Acme\PizzaBundle\AcmePizzaBundle(),
    );
    //...
```

### Create database and schema

``` bash
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
```

### Enable routing configuration

``` yaml
# app/config/routing.yml
AcmePizzaBundle:
    resource: "@AcmePizzaBundle/Controller/"
    type:     annotation
    prefix:   /acme-pizza
```

### Refresh asset folder

``` bash
$ php app/console assets:install web/
```

### Data fixtures (optional)

First, make sure that your db parameters are correctly set in `app/config/parameters.ini`.
You'll need to install ``Doctrine Data Fixtures`` (don't forget to add the
path to `AppKernel.php`) and then run:

``` bash
$ php app/console doctrine:fixtures:load
```

You can read about install instructions in the Symfony2 Cookbook(http://symfony.com/doc/2.0/cookbook/doctrine/doctrine_fixtures.html#setup-and-configuration)

Usage
-----

Go to `app_dev.php/acme-pizza/pizza/list` and start selling pizzas.

Testing
-------

You can launch functional tests with Selenium RC server running with the following
steps:

-   download [selenium server](http://selenium.googlecode.com/files/selenium-server-standalone-2.2.0.jar)
-   edit `app/phpunit.xml.dist`:
    -   add php's server variable to match your configuration
    -   add the selenium's browser configuration. I added [Google Chrome Portable]()
        because it's faster than ie or even firefox.

# app/phpunit.xml.dist

``` xml
# app/phpunit.xml.dist
<!-- ... -->
<php>
    <server
        name  = "KERNEL_DIR"
        value = "/var/www/AcmePizza/app/" />
    <server
        name  = "HTTP_HOST"
        value = "localhost" />
    <server
        name  = "SCRIPT_NAME"
        value = "/AcmePizza/web/app_dev.php" />
</php>
<!-- ... -->

<!-- ... -->
<selenium>
    <browser
        name    = "Google Chrome Portable"
        browser = "*custom c:\bin\GoogleChromePortable\GoogleChromePortable.exe -disable-popup-blocking -proxy-server=127.0.0.1:4444"
        host    = "127.0.0.1" /> <!-- ip of selenium RC server -->
</selenium>
<!-- ... -->
```

Now you can run test (assuming that Selenium RC is running `java -jar selenium-server-standalone-2.2.0.jar`)
with `phpunit -c app/ src/Acme/PizzaBundle/Tests/`
If you want you can submit other missing tests.
