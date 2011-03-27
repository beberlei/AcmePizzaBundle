<?php

namespace Acme\PizzaBundle\Form;

use Symfony\Component\Form\Type\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PizzaItemType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('pizza', 'entity', array(
            'class' => 'Acme\PizzaBundle\Entity\Pizza',
        ));
        $builder->add('count', 'integer');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\PizzaBundle\Entity\PizzaItem',
        );
    }
}