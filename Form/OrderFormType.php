<?php

namespace Acme\PizzaBundle\Form;

use
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder
    ;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('knownCustomer', 'checkbox', array(
                'label'    => 'Known customer',
                'required' => false,
            ))
            ->add('knownPhone', 'text', array(
                'label' => 'Known phone',
            ))
            ->add('address', new Type\AddressType())
            ->add('items', 'collection', array(
                'type'       => new Type\PizzaItemType(),
                'modifiable' => true,
            ))
            ;
    }
}