<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:Entity
 * @orm:Table(name="customer")
 */
class Customer
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
     * @assert:NotBlank(groups="Customer")
     */
    private $name;

    /**
     * @var string $street
     *
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="Customer")
     */
    private $street;

    /**
     * @var string $city
     *
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="Customer")
     */
    private $city;

    /**
     * @var string $phone
     *
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="Customer")
     */
    private $phone;

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
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param $street string
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param $city string
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param $phone string
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
}
