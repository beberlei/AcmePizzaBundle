<?php

namespace Acme\PizzaBundle\Form\Type;

use
    Symfony\Component\Form\Type\AbstractType,
    Symfony\Component\Form\FormBuilder
    ;

class PizzaItemType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('pizza', 'entity', array('class' => 'Acme\PizzaBundle\Entity\Pizza'))
            ->add('count', 'integer')
            ->end()
            ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\PizzaBundle\Entity\PizzaItem',
        );
    }
}
