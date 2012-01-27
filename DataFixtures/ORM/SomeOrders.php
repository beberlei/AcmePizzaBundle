<?php
namespace Acme\PizzaBundle\DataFixtures\ORM;

use
    Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager
    ;

use
    Acme\PizzaBundle\Entity\OrderItem,
    Acme\PizzaBundle\Entity\Order
    ;

class SomeOrders extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 3;
    }

    public function load(ObjectManager $manager)
    {
        foreach (array(
            'Patricia S. Kemp'  => array('Baked Ziti' => 1, 'Sausage-Broccoli Rabe' => 1),
            'Wilfredo N. Croft' => array('Bianco Mortadella' => 1, 'Pepperoni' => 2, 'Lamb-Feta' => 1),
            'Marc Beauchemin'   => array('Pepper Lattice' => 1),
            'Hugues Bureau'     => array('Eggplant' => 1),
            'Dolcelino Pisano'  => array('Meat-Olive' => 1, 'New York-Style' => 1),
            'Steffen Bader'     => array('Salmon-Potato' => 1, 'Onion-Ricotta' => 1, 'Tomato Bianco' => 3, 'New York-Style' => 1),
        ) as $i => $ii) {
            $customer = $manager->getRepository('AcmePizzaBundle:Customer')->findOneByName($i);

            $items = array();

            foreach ($ii as $j => $jj) {

                $pizza = $manager->getRepository('AcmePizzaBundle:Pizza')->findOneByName($j);
                $item = new OrderItem();
                $item->setPizza($pizza);
                $item->setCount($jj);

                $items[] = $item;
            }

            $order = new Order();
            $order->setCustomer($customer);
            foreach ($items as $item) {
                $order->addItem($item);
            }

            $manager->persist($order);
        }

        $manager->flush();
    }
}
