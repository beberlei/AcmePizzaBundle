<?php

namespace Acme\PizzaBundle\Form\Type;

use
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder
    ;

class PizzaItemType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('pizza', 'entity', array(
                'class'         => 'Acme\PizzaBundle\Entity\Pizza',
                'query_builder' => function ($repository) { return $repository->createQueryBuilder('p')->orderBy('p.name', 'ASC'); },
            ))
            ->add('count', 'integer')
            ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\PizzaBundle\Entity\PizzaItem',
        );
    }
}
