<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:entity
 */
class PizzaItem
{
    /**
     * @orm:generatedValue @orm:id @orm:column(type="integer")
     */
    private $id;
    /**
     * @var Pizza
     * @validation:AssertType(type="Acme\PizzaBundle\Entity\Pizza", message="You have to pick a pizza from the list")
     * @orm:ManyToOne(targetEntity="Pizza")
     */
    private $pizza;
    /**
     * @orm:Column(type="integer")
     * @validation:min(1)
     * @var int
     */
    private $count;

    public function __construct(Pizza $pizza = null, $count = 0)
    {
        $this->pizza = $pizza;
        $this->count = $count;
    }

    public function getPizza() {
        return $this->pizza;
    }

    public function setPizza($pizza) {
        $this->pizza = $pizza;
    }

    public function getCount() {
        return $this->count;
    }

    public function setCount($count) {
        $this->count = $count;
    }
}