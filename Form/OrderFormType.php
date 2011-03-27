<?php

namespace Acme\PizzaBundle\Form;

use Symfony\Component\Form\Type\AbstractType;
use Symfony\Component\Form\FormBuilder;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('knownCustomer', 'choice', array(
            'choices' => array(0 => 'No', 1 => 'Yes'),
        ));
        $builder->add('knownPhone', 'text');
        $add = $builder->add('address', new AddressType());
        $builder->add('items', 'collection', array(
            'type' => new PizzaItemType(),
            'modifiable' => true,
        ));
    }
}