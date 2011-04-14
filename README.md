
Acme Pizza Bundle
=================

This is a test-bundle for the experimental form support.

It is very early status and will be finalized as a demo example over the weekend.

Distribution: Best used with [Symfony Standard Edition](https://github.com/symfony/symfony-standard)

Requirements
------------

Symfony has to be loaded from [symfony's form branch](https://github.com/symfony/symfony/commits/form)

    ./bin/vendors.sh --min
    cd vendor/
    rm -rf symfony/
    git clone -b form git://github.com/symfony/symfony.git

Installation
------------

### Register AcmePizzaBundle to Kernel

    # app/AppKernel.php
    [...]
    $bundles = array(
        [...]
        new Acme\PizzaBundle\AcmePizzaBundle(),
    );
    [...]

### Doctrine ORM Mappings Configuration

    # app/config/config.yml
    doctrine:
        [...]
        orm:
            [...]
            entity_managers:
                default:
                    mappings:
                        [...]
                        AcmePizzaBundle: ~

### Create database and schema

    app/console doctrine:database:create
    app/console doctrine:schema:create

### Enable routing configuration

    # app/config/routing.yml
    acme-pizza_pizza:
        resource: "@AcmePizzaBundle/Controller/PizzaController.php"
        type:     annotation
    
    acme-pizza_order:
        resource: "@AcmePizzaBundle/Controller/OrderController.php"
        type:     annotation

### Refresh asset folder

    ./app/console assets:install web/

### Data fixtures (optional)

First, make sure that your db parameters are correctly set in `app/config/parameters.ini`.
You'll need to install [Doctrine Data Fixtures](git://github.com/doctrine/data-fixtures.git)
(don't forget to add the path to `AppKernel.php`) and then run:

    ./app/console doctrine:data:load

Usage
-----

Go to `app_dev.php/acme-pizza/pizza/list` and start selling pizzas.

Testing
-------

You can launch functional tests with Selenium RC server running with the following
steps:

-   download [selenium server](http://selenium.googlecode.com/files/selenium-server-standalone-2.0b3.jar)
-   edit `app/phpunit.xml.dist`:
    -   add php's server variable to match your configuration
    -   add the selenium's browser configuration. I added [Google Chrome Portable]()
        because it's faster than ie or even firefox.

# app/phpunit.xml.dist

    # app/phpunit.xml.dist
    [...]
    <php>
        <server name="KERNEL_DIR" value="/var/www/AcmePizza/app/" />
        <server name="HTTP_HOST" value="localhost" />
        <server name="SCRIPT_NAME" value="/AcmePizza/web/app_dev.php" />
    </php>
    [...]

    [...]
    <selenium>
        <browser
            name    = "Google Chrome Portable"
            browser = "*custom c:\bin\GoogleChromePortable\GoogleChromePortable.exe --disable-popup-blocking --proxy-server=127.0.0.1:4444"
            host    = "127.0.0.1" /> <!-- ip of selenium RC server -->
    </selenium>
    [...]

Now you can run test (assuming that Selenium RC is running `java -jar selenium-server-standalone-2.0b3.jar`) with `phpunit -c app/phpunit.xml.dist`
If you want you can submit other missing tests.
