
Acme Pizza Bundle
=================

This is a test-bundle for the experimental form support.

It is very early status and will be finalized as a demo example over the weekend.

Distribution: Best used with [Symfony Standard Edition](https://github.com/symfony/symfony-standard)

Requirements
------------

Symfony has to be loaded from [bschussek's experimental branch](https://github.com/bschussek/symfony/tree/experimental)
Edit `bin/vendors.sh` and update symfony's github path from
`git://github.com/symfony/symfony.git #v$VERSION` to
`git://github.com/bschussek/symfony.git origin/experimental` then run:

    rm -rf vendor/symfony/
    ./bin/vendors.sh --min

If you want to merge latest improvement of symfony 

    cd symfony
    git remote add upstream git://github.com/symfony/symfony.git
    git fetch upstream -v
    git merge upstream/master

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
                        AcmePizza: ~

### Create database and schema

    app/console doctrine:database:create
    app/console doctrine:schema:create

### Enable routing configuration

    # app/config/routing.yml
    _pizza_pizza:
        resource: "@AcmePizza/Controller/PizzaController.php"
        type:     annotation
    
    _pizza_order:
        resource: "@AcmePizza/Controller/OrderController.php"
        type:     annotation

### Refresh asset folder

    ./app/console assets:install web/

Usage
-----

Go to `app_dev.php/pizza/order/index`
