<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:Entity
 */
class Pizza
{
    /**
     * @var integer $id
     *
     * @orm:GeneratedValue
     * @orm:Id
     * @orm:Column(type="integer")
     */
    private $id;

    /**
     * @var string $name
     *
     * @orm:Column(type="string")
     * @assert:NotBlank()
     * @assert:MinLength(5)
     */
    private $name;

    /**
     * @var decimal $price
     *
     * @orm:Column(type="decimal", scale=2, precision=5)
     * @assert:NotBlank()
     * @assert:Min(2)
     */
    private $price;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name string
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return decimal
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param $price decimal
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
