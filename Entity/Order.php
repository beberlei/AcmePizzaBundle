<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:Entity
 * @orm:Table(name="order_")
 */
class Order
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
     * @var \DateTime
     * 
     * @orm:Column(type="datetime")
     */
    protected $date;

    /**
     * @var \Acme\PizzaBundle\Entity\Customer
     *
     * @orm:ManyToOne(targetEntity="Customer", cascade={"persist"})
     */
    protected $customer;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * 
     * @orm:OneToMany(targetEntity="OrderItem", mappedBy="order", cascade={"persist"})
     */
    protected $items;

    /**
     * 
     */
    public function __construct()
    {
        $this->date  = new \DateTime('now');
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Get the date
     * 
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the date
     * 
     * @param \DateTime
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Get the related customer
     * 
     * @return \Acme\PizzaBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set the related customer
     * 
     * @param \Acme\PizzaBundle\Entity\Customer $customer
     */
    public function setCustomer(\Acme\PizzaBundle\Entity\Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Get the collection of related items
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set the collection of related items
     * 
     * @param \Doctrine\Common\Collections\ArrayCollection $items
     */
    public function setItems(\Doctrine\Common\Collections\ArrayCollection $items)
    {
        $this->items = $items;
    }

    /**
     * Add a item to the collection of related items
     * 
     * @param Acme\PizzaBundle\Entity\OrderItem $item
     */
    public function addItem(\Acme\PizzaBundle\Entity\OrderItem $item)
    {
        $this->items->add($item);
        $item->setOrder($this);
    }

    /**
     * Remove a item from the collection of related items
     * 
     * @param Acme\PizzaBundle\Entity\OrderItem $item
     */
    public function removeItem(\Acme\PizzaBundle\Entity\OrderItem $item)
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
