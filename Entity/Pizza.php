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
     * @var float
     * 
     * @orm:Column(type="decimal", precision=5, scale=2)
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
     * Set the name
     * 
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Set the price
     * 
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get the price
     * 
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set a property
     * 
     * @param string $name
     * @param mixed  $value
     * 
     * @throws \InvalidArgumentException If the property does not exists
     */
    public function set($name, $value)
    {
        switch ($name) {
            case 'name':
                $this->setName($value);
                break;

            case 'price':
                $this->setPrice($value);
                break;

            case 'id':
                $this->setId($value);
                break;

            default:
                throw new \InvalidArgumentException(sprintf('The property "%s" does not exists.', $name));
        }
    }

    /**
     * Get a property
     * 
     * @param string $name
     * 
     * @return mixed
     * 
     * @throws \InvalidArgumentException If the property does not exists
     */
    public function get($name)
    {
        switch ($name) {
            case 'name':
                return $this->getName($value);

            case 'price':
                return $this->getPrice($value);

            case 'id':
                return $this->getId($value);

            default:
                throw new \InvalidArgumentException(sprintf('The property "%s" does not exists.', $name));
        }
    }

    public function __toString()
    {
        return $this->name . "(". $this->price . ")";
    }
}
