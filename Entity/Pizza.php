<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:Entity
 */
class Pizza
{
    /**
     * @orm:GeneratedValue
     * @orm:Id
     * @orm:Column(type="integer")
     */
    private $id;

    /**
     * @orm:Column(type="string")
     * @assert:NotBlank()
     * @assert:MinLength(5)
     */
    private $name;

    /**
     * @orm:Column(type="decimal", scale=2, precision=5)
     * @assert:NotBlank()
     * @assert:Min(2)
     */
    private $price;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function __toString()
    {
        return $this->name . "(". $this->price . ")";
    }
}
