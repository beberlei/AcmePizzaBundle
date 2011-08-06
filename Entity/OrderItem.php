<?php

namespace Acme\PizzaBundle\Entity;

use
    Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert
;

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
     * @var Order
     * 
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="items")
     */
    protected $order;

    /**
     * @var Pizza
     * 
     * @ORM\ManyToOne(targetEntity="Pizza")
     * @Assert\NotBlank()
     */
    protected $pizza;

    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Min(1)
     * @Assert\Type("integer")
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
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the related order
     * 
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the related pizza
     * 
     * @param Pizza $pizza
     */
    public function setPizza(Pizza $pizza)
    {
        $this->pizza = $pizza;
    }

    /**
     * Get the related pizza
     * 
     * @return Pizza
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
            case 'order':
                $this->setOrder($value);
                break;

            case 'pizza':
                $this->setPizza($value);
                break;

            case 'count':
                $this->setCount($value);
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
