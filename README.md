
Acme Pizza Bundle
=================

This is a test-bundle for the experimental form support.

It is very early status and will be finalized as a demo example over the weekend.

Distribution: Best used with [Symfony Standard Edition](https://github.com/symfony/symfony-standard)

Requirements
------------

Symfony has to be loaded from [bschussek's experimental branch](https://github.com/bschussek/symfony/tree/experimental)

    cd vendor/
    rm -rf symfony/
    git clone --depth 1 -b experimental git://github.com/bschussek/symfony.git

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
    pizza:
        resource: "@AcmePizzaBundle/Resources/config/routing.yml"

### Refresh asset folder

    ./app/console assets:install web/

Usage
-----

Go to `app_dev.php/pizza`
