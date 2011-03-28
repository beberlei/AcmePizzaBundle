<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:entity
 */
class Pizza
{
    /**
     * @orm:generatedValue @orm:id @orm:column(type="integer")
     */
    private $id;
    /**
     * @orm:column(type="string")
     * @assert:NotBlank()
     * @assert:MinLength(5)
     */
    private $name;
    /**
     * @assert:Min(2)
     * @orm:column(type="decimal", scale=2, precision=5)
     * 
     */
    private $price;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function __toString()
    {
        return $this->name . "(". $this->price . ")";
    }
}