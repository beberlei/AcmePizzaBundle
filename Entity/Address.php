<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:entity
 */
class Address
{
    /**
     * @orm:generatedValue @orm:id @orm:column(type="integer")
     */
    private $id;
    /**
     * @orm:column(type="string")
     * @validation:NotBlank
     */
    private $name;
    /**
     * @orm:column(type="string")
     * @validation:NotBlank
     */
    private $street;
    /**
     * @orm:column(type="string")
     * @validation:NotBlank
     */
    private $city;
    /**
     * @orm:column(type="string")
     * @validation:NotBlank
     */
    private $phone;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getStreet() {
        return $this->street;
    }

    public function setStreet($street) {
        $this->street = $street;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }
}