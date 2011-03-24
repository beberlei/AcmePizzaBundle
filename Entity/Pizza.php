<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:entity
 */
class Pizza
{
    /** @orm:generatedValue @orm:id @orm:column(type="integer") */
    private $id;
    private $name;
}