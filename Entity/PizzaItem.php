<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @orm:entity
 */
class PizzaItem
{
    /** @orm:generatedValue @orm:id @orm:column(type="integer") */
    private $id;
    private $pizza;
    private $count;

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