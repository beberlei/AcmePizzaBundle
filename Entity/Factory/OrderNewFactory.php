<?php

namespace Acme\PizzaBundle\Entity\Factory;

use
    Symfony\Component\Validator\ExecutionContext,
    Symfony\Component\Validator\Constraints as Assert,
    Acme\PizzaBundle\Entity\Order,
    Acme\PizzaBundle\Entity\Customer
;

/**
 * @Assert\callback(methods={"isValidCustomer", "pickedOrderItems"})
 */
class OrderNewFactory
{
    /**
     * @var Order
     */
    private $order;

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
     * @Assert\Valid()
     */
    private $items = array();

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @param \Doctrine\ORM\EntityManager $em
     * @param Order $order
     */
    public function __construct($em, Order $order)
    {
        $this->order = $order;

        $this->em = $em;
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

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->order->setCustomer($customer);
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->order->getCustomer();
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return \Doctrine\ORM\PersistentCollection
     */
    public function getItems()
    {
        return $this->order->getItems();
    }

    /**
     * @param array $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @param  ExecutionContext $context
     * @return bool
     */
    public function isValidCustomer(ExecutionContext $context)
    {
        return true;

        if (true === $this->known_customer) {

            $this->customer = $this->em
                ->getRepository('AcmePizzaBundle:Customer')
                ->findOneBy(array(
                    'phone' => $this->known_phone,
                ))
            ;

            if (false === ($this->customer instanceof Customer)) {
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
            $group = 'Customer';

            $context->getGraphWalker()->walkReference(
                $this->customer,
                $group,
                $context->getPropertyPath() . ".customer",
                true
            );
        }

        /*
        if (!($this->customer instanceof Customer)) {
            $context->addViolation('Invalid customer given', array(), $this->customer);
        }
        */
    }

    /**
     * @param  ExecutionContext $context
     * @return void
     */
    public function pickedOrderItems(ExecutionContext $context)
    {
        $count = 0;

        foreach ($this->order->getItems() as $item) {
            /* @var $item \Acme\PizzaBundle\Entity\OrderItem */
            $count += $item->getCount();
        }

        if ($count === 0) {
            /*
            $property_path = $context->getPropertyPath() . '.customer.phone';
            $property_path = $context->getPropertyPath() . '.items[0].count';
            $property_path = $context->getPropertyPath() . '.items.[0].count';
            $property_path = $context->getPropertyPath() . '.items.0.count';
            */
            $property_path = $context->getPropertyPath() . '.items[0].count';
            $context->setPropertyPath($property_path);
            $context->addViolation('You have to pick at least one pizza...', array(), null);
        }
    }

    /**
     * @return \Acme\PizzaBundle\Entity\Order
     */
    public function make()
    {
        $order = new Order();
        $order->setCustomer($this->customer);

        foreach ($this->items as $item) {
            $order->addItem($item);
        }

        return $order;
    }
}
