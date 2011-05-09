<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:Entity
 * @orm:Table(name="customer")
 */
class Customer
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
     * @assert:NotBlank(groups="Customer")
     */
    protected $name;

    /**
     * @var string
     * 
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="Customer")
     */
    protected $street;

    /**
     * @var string
     * 
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="Customer")
     */
    protected $city;

    /**
     * @var string
     * 
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="Customer")
     */
    protected $phone;

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
     * Set the street
     * 
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Get the street
     * 
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set the city
     * 
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get the city
     * 
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the phone
     * 
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get the phone
     * 
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
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

            case 'street':
                $this->setStreet($value);
                break;

            case 'city':
                $this->setCity($value);
                break;

            case 'phone':
                $this->setPhone($value);
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

            case 'street':
                return $this->getStreet($value);

            case 'city':
                return $this->getCity($value);

            case 'phone':
                return $this->getPhone($value);

            case 'id':
                return $this->getId($value);

            default:
                throw new \InvalidArgumentException(sprintf('The property "%s" does not exists.', $name));
        }
    }
}
