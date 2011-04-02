<?php

namespace Acme\PizzaBundle\Form;

use
    Symfony\Component\Form\Type\AbstractType,
    Symfony\Component\Form\FormBuilder
    ;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('street', 'text')
            ->add('city', 'text')
            ->add('phone', 'text')
            ->end()
            ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\PizzaBundle\Entity\Address',
        );
    }
}