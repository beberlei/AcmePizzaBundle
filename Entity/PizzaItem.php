<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:entity
 */
class PizzaItem
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
     * @var \Acme\PizzaBundle\Entity\Order $order
     *
     * @orm:ManyToOne(targetEntity="Order", inversedBy="items")
     */
    private $order;

    /**
     * @var \Acme\PizzaBundle\Entity\Pizza $pizza
     *
     * @orm:ManyToOne(targetEntity="Pizza")
     * @assert:Type(type="Acme\PizzaBundle\Entity\Pizza", message="You have to pick a pizza from the list")
     */
    private $pizza;

    /**
     * @var integer $count
     *
     * @orm:Column(type="integer")
     * @assert:Min(0)
     */
    private $count;

    public function __construct(Pizza $pizza = null, $count = 0)
    {
        $this->pizza = $pizza;
        $this->count = (int) $count;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Acme\PizzaBundle\Entity\Order The related entity
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param \Acme\PizzaBundle\Entity\Order $order The related entity
     */
    public function setOrder(\Acme\PizzaBundle\Entity\Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return \Acme\PizzaBundle\Entity\Pizza The related entity
     */
    public function getPizza()
    {
        return $this->pizza;
    }

    /**
     * @param \Acme\PizzaBundle\Entity\Pizza $pizza The related entity
     */
    public function setPizza(\Acme\PizzaBundle\Entity\Pizza $pizza)
    {
        $this->pizza = $pizza;
    }

    /**
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param $count integer
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
