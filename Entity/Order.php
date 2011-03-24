<?php

namespace Acme\PizzaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @orm:entity
 * @orm:table(name="PizzaOrder")
 */
class Order
{
    /** @orm:generatedValue @orm:id @orm:column(type="integer") */
    private $id;
    /**
     * @orm:column(type="datetime")
     */
    private $date;
    /**
     * @orm:column(type="boolean")
     * @var bool
     */
    private $knownCustomer;
    /**
     * @orm:ManyToOne(targetEntity="Address")
     * @var Address
     */
    private $address;
    /**
     * @orm:OneToMany(targetEntity="PizzaItem", mappedBy="order")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->items[] = new PizzaItem();
        $this->date = new \DateTime("now");
    }

    public function setKnownCustomer($bool)
    {
        $this->knownCustomer = (bool)$bool;
    }

    public function getKnownCustomer()
    {
        return $this->knownCustomer;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getItems()
    {
        return $this->items;
    }
}