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
            ->add('name')
            ->add('street')
            ->add('city')
            ->add('phone')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'Acme\PizzaBundle\Entity\Customer');
    }

    public function getName()
    {
        return 'customer';
    }
}
