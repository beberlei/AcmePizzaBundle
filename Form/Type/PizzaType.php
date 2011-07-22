<?php

namespace Acme\PizzaBundle\Form\Type;

use
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder
;

class PizzaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('price', 'money')
        ;
    }

     public function getName()
    {
        return 'pizza';
    }
}
