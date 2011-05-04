<?php

namespace Acme\PizzaBundle\Form\Type;

use
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder
    ;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('street', 'text')
            ->add('city', 'text')
            ->add('phone', 'text')
            ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\PizzaBundle\Entity\Customer',
        );
    }
}