<?php

namespace Acme\PizzaBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="pizza")
 */
class Pizza
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
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\MinLength(5)
     */
    protected $name;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=5, scale=2)
     * @Assert\NotBlank()
     * @Assert\Min(2)
     */
    protected $price;

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
     * Set the name
     * 
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the price
     * 
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get the price
     * 
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
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
            case 'name':
                $this->setName($value);
                break;

            case 'price':
                $this->setPrice($value);
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
            case 'name':
                return $this->getName($value);

            case 'price':
                return $this->getPrice($value);

            case 'id':
                return $this->getId($value);

            default:
                throw new \InvalidArgumentException(sprintf('Generic getter for "%s" is not defined', $name));
        }
    }

    public function __toString()
    {
        return $this->name . "(". $this->price . ")";
    }
}
