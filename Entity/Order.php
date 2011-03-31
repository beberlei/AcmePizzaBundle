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
     * @orm:ManyToOne(targetEntity="Address", cascade={"persist"})
     * @var Address
     */
    private $address;

    /**
     * @orm:OneToMany(targetEntity="PizzaItem", mappedBy="order", cascade={"persist"})
     */
    private $items;

    public function __construct(Address $address, array $items)
    {
        $this->date    = new \DateTime("now");
        $this->address = $address;
        $this->items   = new ArrayCollection($items);
        foreach ($this->items as $item) {
            $item->setOrder($this);
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getItems() {
        return $this->items;
    }
}