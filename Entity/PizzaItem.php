<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:entity
 */
class PizzaItem
{
    /**
     * @orm:GeneratedValue
     * @orm:Id
     * @orm:Column(type="integer")
     */
    private $id;

    /**
     * @orm:ManyToOne(targetEntity="Order", inversedBy="items")
     */
    private $order;

    /**
     * @var Pizza
     * @assert:Type(type="Acme\PizzaBundle\Entity\Pizza", message="You have to pick a pizza from the list")
     * @orm:ManyToOne(targetEntity="Pizza")
     */
    private $pizza;

    /**
     * @orm:Column(type="integer")
     * @assert:Min(0)
     * @var int
     */
    private $count;

    public function __construct(Pizza $pizza = null, $count = 0)
    {
        $this->pizza = $pizza;
        $this->count = $count;
    }

    public function getPizza()
    {
        return $this->pizza;
    }

    public function setPizza($pizza)
    {
        $this->pizza = $pizza;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }
}
