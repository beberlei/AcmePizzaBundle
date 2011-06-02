<?php

namespace Acme\PizzaBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_item")
 */
class OrderItem
{
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \Acme\PizzaBundle\Entity\Order
     * 
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="items")
     */
    protected $order;

    /**
     * @var \Acme\PizzaBundle\Entity\Pizza
     * 
     * @ORM\ManyToOne(targetEntity="Pizza")
     * @Assert\Type(type="Acme\PizzaBundle\Entity\Pizza", message="You have to pick a pizza from the list")
     */
    protected $pizza;

    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     * @Assert\Min(0)
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
     * Set the related order
     * 
     * @param \Acme\PizzaBundle\Entity\Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
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
     * Set the related pizza
     * 
     * @param \Acme\PizzaBundle\Entity\Pizza $pizza
     */
    public function setPizza(Pizza $pizza)
    {
        $this->pizza = $pizza;
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
     * Set the count
     * 
     * @param integer $count
     */
    public function setCount($count)
    {
        $this->count = $count;
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
            case 'count':
                $this->setCount($value);
                break;

            case 'id':
                $this->setId($value);
                break;

            default:
                throw new \InvalidArgumentException(sprintf('Generic setter for "%s" is not defined', $name));
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
            case 'count':
                return $this->getCount($value);

            case 'id':
                return $this->getId($value);

            default:
                throw new \InvalidArgumentException(sprintf('Generic getter for "%s" is not defined', $name));
        }
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->pizza->getPrice() * $this->count;
    }
}
