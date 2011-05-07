<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:Entity
 * @orm:Table(name="pizza")
 */
class Pizza
{
    /**
     * @var integer
     * 
     * @orm:GeneratedValue
     * @orm:Id
     * @orm:Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * 
     * @orm:Column(type="string")
     * @assert:NotBlank()
     * @assert:MinLength(5)
     */
    protected $name;

    /**
     * @var decimal
     * 
     * @orm:Column(type="decimal", scale=2, precision=5)
     * @assert:NotBlank()
     * @assert:Min(2)
     */
    protected $price;

    /**
     * Get the id
     * 
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name
     * 
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the price
     * 
     * @return decimal
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the price
     * 
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function __toString()
    {
        return $this->name . "(". $this->price . ")";
    }
}
