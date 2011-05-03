<?php

namespace Acme\PizzaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @orm:Entity
 * @orm:Table(name="PizzaOrder")
 */
class Order
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
     * @var \DateTime $date
     * 
     * @orm:Column(type="datetime")
     */
    private $date;

    /**
     * @var \Acme\PizzaBundle\Entity\Address $address
     * 
     * @orm:ManyToOne(targetEntity="Address", cascade={"persist"})
     */
    private $address;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $items
     * 
     * @orm:OneToMany(targetEntity="PizzaItem", mappedBy="order", cascade={"persist"})
     */
    private $items;

    public function __construct()
    {
        $this->date  = new \DateTime('now');
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param $date \DateTime
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return \Acme\PizzaBundle\Entity\Address The related entity
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param \Acme\PizzaBundle\Entity\Address $address The related entity
     */
    public function setAddress(\Acme\PizzaBundle\Entity\Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection The collection of related entities
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $items The collection of related entities
     */
    public function setItems(\Doctrine\Common\Collections\ArrayCollection $items)
    {
        $this->items = $items;
    }

    /**
     * @param Acme\PizzaBundle\Entity\PizzaItem $item
     */
    public function addItem(\Acme\PizzaBundle\Entity\PizzaItem $item)
    {
        $this->items->add($item);
        $item->setOrder($this);
    }

    /**
     * @param Acme\PizzaBundle\Entity\PizzaItem $item
     */
    public function removeItem(\Acme\PizzaBundle\Entity\PizzaItem $item)
    {
        $this->items->removeElement($item);
    }

    public function getTotal()
    {
        $total = 0.0;

        foreach ($this->items as $item) {
            $total+= $item->getTotal();
        }

        return $total;
    }
}
