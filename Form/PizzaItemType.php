<?php

namespace Acme\PizzaBundle\Form;

use Symfony\Component\Form\Type\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PizzaItemType extends AbstractType
{
    public function configure(FormBuilder $builder, array $options)
    {
        $builder->setDataClass('Acme\PizzaBundle\Entity\PizzaItem');
        $builder->add('pizza', 'entity', array(
            'class' => 'Acme\PizzaBundle\Entity\Pizza',
        ));
        $builder->add('count', 'integer');
    }
}