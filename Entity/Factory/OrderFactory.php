<?php

namespace Acme\PizzaBundle\Entity\Factory;

use
    Symfony\Component\Validator\ExecutionContext,
    Acme\PizzaBundle\Entity\Order,
    Acme\PizzaBundle\Entity\Address
    ;

/**
 * @assert:callback(methods={"isValidAddress", "pickedPizzaItems"})
 */
class OrderFactory
{
    /**
     * @var bool
     */
    private $known_customer = false;

    /**
     * Phone number of known customer.
     *
     * @var string
     */
    private $known_phone = '';

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

    public function setKnownPhone($known_phone)
    {
        $this->known_phone = $known_phone;
    }

    public function getKnownPhone()
    {
        return $this->known_phone;
    }

    public function isKnownCustomer()
    {
        return $this->known_customer;
    }

    public function setKnownCustomer($boolean)
    {
        $this->known_customer = $boolean;
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
    public function isValidAddress(ExecutionContext $context)
    {
        // https://gist.github.com/888267

        if (true === $this->known_customer) {

            $this->address = $this->em
                ->getRepository('AcmePizzaBundle:Address')
                ->findOneBy(array(
                    'phone' => $this->known_phone,
                ))
                ;

            if (false === ($this->address instanceof Address)) {
                $property_path = $context->getPropertyPath() . '.known_phone';

                $context->setPropertyPath($property_path);
                $context->addViolation('Phone number is not registered', array(), null);
            }

        } else {

            /*
            $context->setGroup('MyTest');
            var_dump($context->getGroup());
            */

            $group = $context->getGroup();
            $group = 'Address';

            $context->getGraphWalker()->walkReference(
                $this->address,
                $group,
                $context->getPropertyPath() . ".address",
                true
            );
        }

        /*
        if (!($this->address instanceof Address)) {
            $context->addViolation('Invalid address given', array(), $this->address);
        }
        */
    }

    /**
     * @param  ExecutionContext $context
     * @return void
     */
    public function pickedPizzaItems(ExecutionContext $context)
    {
        $count = 0;

        foreach ($this->items as $item) {
            $count += $item->getCount();
        }

        if ($count === 0) {
            /*
            $property_path = $context->getPropertyPath() . '.address.phone';
            $property_path = $context->getPropertyPath() . '.items[0].count';
            $property_path = $context->getPropertyPath() . '.items.0.count';
            */
            $property_path = $context->getPropertyPath() . '.items.[0].count'; // ok
            $context->setPropertyPath($property_path);
            $context->addViolation('You have to pick at least one pizza...', array(), null);
        }
    }

    /**
     * @return \Acme\PizzaBundle\Entity\Order
     */
    public function make()
    {
        $order = new Order($this->address, $this->items);

        return $order;
    }
}
