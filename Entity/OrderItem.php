<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:Entity
 * @orm:Table(name="order_item")
 */
class OrderItem
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
     * @var \Acme\PizzaBundle\Entity\Order
     * 
     * @orm:ManyToOne(targetEntity="Order", inversedBy="items")
     */
    protected $order;

    /**
     * @var \Acme\PizzaBundle\Entity\Pizza
     * 
     * @orm:ManyToOne(targetEntity="Pizza")
     * @assert:Type(type="Acme\PizzaBundle\Entity\Pizza", message="You have to pick a pizza from the list")
     */
    protected $pizza;

    /**
     * @var integer
     * 
     * @orm:Column(type="integer")
     * @assert:Min(0)
     */
    protected $count;

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
     * Get the related order
     * 
     * @return \Acme\PizzaBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the related order
     * 
     * @param \Acme\PizzaBundle\Entity\Order $order
     */
    public function setOrder(\Acme\PizzaBundle\Entity\Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the related pizza
     * 
     * @return \Acme\PizzaBundle\Entity\Pizza
     */
    public function getPizza()
    {
        return $this->pizza;
    }

    /**
     * Set the related pizza
     * 
     * @param \Acme\PizzaBundle\Entity\Pizza $pizza
     */
    public function setPizza(\Acme\PizzaBundle\Entity\Pizza $pizza)
    {
        $this->pizza = $pizza;
    }

    /**
     * Get the count
     * 
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set the count
     * 
     * @param integer $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->pizza->getPrice() * $this->count;
    }
}
