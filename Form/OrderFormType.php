<?php

namespace Acme\PizzaBundle\Form;

use
    Symfony\Component\Form\Type\AbstractType,
    Symfony\Component\Form\FormBuilder
    ;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('knownCustomer', 'choice', array(
                'choices'  => array(0 => 'No', 1 => 'Yes'),
                'expanded' => true,
            ))
            ->add('knownPhone', 'text')
            ->add('address', new AddressType())
            ->add('items', 'collection', array(
                'type'       => new PizzaItemType(),
                'modifiable' => true,
            ))
            ->end()
            ;
    }
}