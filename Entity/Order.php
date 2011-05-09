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
     * @orm:Column(type="integer")
     * @orm:Id
     * @orm:GeneratedValue(strategy="IDENTITY")
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
     * Set the date
     * 
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
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
     * Set the related customer
     * 
     * @param \Acme\PizzaBundle\Entity\Customer $customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
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
     * @param \Acme\PizzaBundle\Entity\OrderItem $item
     */
    public function addItem(OrderItem $item)
    {
        $this->items->add($item);
        $item->setOrder($this);
    }

    /**
     * Remove a item from the collection of related items
     * 
     * @param \Acme\PizzaBundle\Entity\OrderItem $item
     */
    public function removeItem(OrderItem $item)
    {
        $this->items->removeElement($item);
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
            case 'date':
                $this->setDate($value);
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
            case 'date':
                return $this->getDate($value);

            case 'id':
                return $this->getId($value);

            default:
                throw new \InvalidArgumentException(sprintf('The property "%s" does not exists.', $name));
        }
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
