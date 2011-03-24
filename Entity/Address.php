<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:entity
 */
class Address
{
    /** @orm:generatedValue @orm:id @orm:column(type="integer") */
    private $id;
    /** @orm:column(type="string") */
    private $name;
    /** @orm:column(type="string") */
    private $street;
    /** @orm:column(type="string") */
    private $city;
    /** @orm:column(type="string") */
    private $phone;
}