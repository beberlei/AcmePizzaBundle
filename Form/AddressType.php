<?php

namespace Acme\PizzaBundle\Form;

use Symfony\Component\Form\Type\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddressType extends AbstractType
{
    public function configure(FormBuilder $builder, array $options)
    {
        $builder->setDataClass('Acme\PizzaBundle\Entity\Address');
        $builder->add('name', 'text');
        $builder->add('street', 'text');
        $builder->add('city', 'text');
        $builder->add('phone', 'text');
    }
}