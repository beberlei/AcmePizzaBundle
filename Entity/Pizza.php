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
     * @orm:Column(type="integer")
     * @orm:Id
     * @orm:GeneratedValue(strategy="IDENTITY")
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
     * @orm:Column(type="decimal", precision="5", scale="2")
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
     * @param double $price
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
