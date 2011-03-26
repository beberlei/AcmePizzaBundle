<?php

namespace Acme\PizzaBundle\Form;

use Symfony\Component\Form\Type\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PizzaType extends AbstractType
{
    public function configure(FormBuilder $builder, array $options)
    {
        $builder->setDataClass('Acme\PizzaBundle\Entity\Pizza');
        $builder->add('name', 'text');
        $builder->add('price', 'money');
    }
}