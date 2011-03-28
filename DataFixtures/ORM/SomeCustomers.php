<?php
namespace Acme\PizzaBundle\DataFixtures\ORM;

use
    Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Acme\PizzaBundle\Entity\Address
    ;

class SomeCustomers extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 1;
    }
    
    public function load($manager)
    {
        foreach(array(
            array(
                'name'   => 'Patricia S. Kemp',
                'street' => '3347 Duck Creek Road',
                'city'   => 'Palo Alto, CA 94306',
                'phone'  => '650-813-0200',
            ),
            array(
                'name'   => 'Wilfredo N. Croft',
                'street' => '3849 Emeral Dreams Drive',
                'city'   => 'Seward, IL 61063',
                'phone'  => '815-247-4027',
            ),
            array(
                'name'   => 'Marc Beauchemin',
                'street' => '15, Rue du Limas',
                'city'   => '21200 BEAUNE',
                'phone'  => '03.28.14.71.40',
            ),
            array(
                'name'   => 'Hugues Bureau',
                'street' => '64, rue Reine Elisabeth',
                'city'   => '48000 MENDE',
                'phone'  => '04.62.86.54.80',
            ),
            array(
                'name'   => 'Dolcelino Pisano',
                'street' => 'Via Partenope, 114',
                'city'   => '47010-Terra Del Sole FO',
                'phone'  => '0343 3604763',
            ),
            array(
                'name'   => 'Steffen Bader',
                'street' => 'Brandenburgische Straße 85',
                'city'   => '13059 Berlin Hohenschönhausen',
                'phone'  => '030 18 17 74',
            ),
        ) as $customer) {

            $address = new Address();

            $address->setName($customer['name']);
            $address->setStreet($customer['street']);
            $address->setCity($customer['city']);
            $address->setPhone($customer['phone']);

            $manager->persist($address);
        }
        
        $manager->flush();
    }
}
