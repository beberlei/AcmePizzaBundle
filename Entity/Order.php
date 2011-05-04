<?php

namespace Acme\PizzaBundle\Entity;

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
     * @var \Acme\PizzaBundle\Entity\Customer $customer
     *
     * @orm:ManyToOne(targetEntity="Customer", cascade={"persist"})
     */
    private $customer;

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
     * @return \Acme\PizzaBundle\Entity\Customer The related entity
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param \Acme\PizzaBundle\Entity\Customer $customer The related entity
     */
    public function setCustomer(\Acme\PizzaBundle\Entity\Customer $customer)
    {
        $this->customer = $customer;
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
