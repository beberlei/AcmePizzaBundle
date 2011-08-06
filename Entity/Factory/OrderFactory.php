<?php

namespace Acme\PizzaBundle\Entity\Factory;

use
    Symfony\Component\Validator\ExecutionContext,
    Symfony\Component\Validator\Constraints as Assert,
    Acme\PizzaBundle\Entity\Order,
    Acme\PizzaBundle\Entity\Customer
;

/**
 * @Assert\Callback(methods={"isValidCustomer"})
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
     * @var Customer
     */
    private $customer;

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
     */
    public function __construct($em)
    {
        $this->em = $em;
        $this->customer = new Customer();
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

    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer()
    {
        return $this->customer;
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
    public function isValidCustomer(ExecutionContext $context)
    {
        // https://gist.github.com/888267

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
     * @deprecated
     */
    public function pickedOrderItems(ExecutionContext $context)
    {
        $count = 0;

        foreach ($this->items as $item) {
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
