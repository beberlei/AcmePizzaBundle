<?php

namespace Acme\PizzaBundle\Entity;

/**
 * @assert:callback(methods={"isValidAddress", "pickedPizzaItems"})
 */
class OrderFactory
{
    /**
     * @var bool
     */
    private $knownCustomer = false;

    /**
     * Phone number of known customer.
     *
     * @var string
     */
    private $knownPhone = "";

    /**
     * @var Address
     */
    private $address;

    /**
     * @assert:Valid()
     */
    private $items = array();

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct($em)
    {
        $this->em = $em;
        $this->address = new Address();
    }

    public function setKnownPhone($phone)
    {
        $this->knownPhone = $phone;
    }

    public function getKnownPhone()
    {
        return $this->knownPhone;
    }

    public function isKnownCustomer()
    {
        return $this->knownCustomer;
    }

    public function setKnownCustomer($bool)
    {
        $this->knownCustomer = (bool)$bool;
    }

    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @param  ExecutionContext $context
     * @return bool
     */
    public function isValidAddress($context)
    {
        if ($this->knownCustomer) {
            $this->address = $this->em->getRepository('AcmePizza:Address')->findOneBy(array('phone' => $this->knownPhone));
        } else {
            $context->getGraphWalker()->walkReference(
                $this->address,
                $context->getGroup(),
                $context->getPropertyPath() . ".address",
                true
            );
        }
        if (!($this->address instanceof Address)) {
            $context->addViolation('Invalid address given', array(), $this->address);
        }
    }

    /**
     * @param  ExecutionContext $context
     * @return void
     */
    public function pickedPizzaItems($context)
    {
        $count = 0;

        foreach ($this->items as $item) {
            $count += $item->getCount();
        }

        if ($count === 0) {
            $context->setPropertyPath($context->getPropertyPath().'.items');
            $context->addViolation('You have to pick at least one pizza...', array(), null);
        }
    }

    /**
     * @return Order
     */
    public function createOrder()
    {
        return new Order($this->address, $this->items);
    }
}
