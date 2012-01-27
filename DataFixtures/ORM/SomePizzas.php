<?php
namespace Acme\PizzaBundle\DataFixtures\ORM;

use
    Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager
    ;

use
    Acme\PizzaBundle\Entity\Pizza
    ;

class SomePizzas extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        foreach (array(
            'Margherita'            =>  7.90,
            'Tomato Pie'            =>  8.50,
            'Quattro Stagioni'      =>  7.90,
            'Puttanesca'            => 10.50,
            'Roasted Pepper'        =>  9.90,
            'New York-Style'        =>  9.90,
            'Pepperoni-Mushroom'    => 11.50,
            'Sausage-Broccoli Rabe' =>  7.90,
            'Stuffed Crust'         => 10.90,
            'Meatball'              =>  9.90,
            'Meat-Olive'            => 11.50,
            'Eggplant'              =>  7.90,
            'Pepperoni'             =>  8.50,
            'Herb'                  => 12.90,
            'Fennel-Taleggio'       => 12.90,
            'Baked Ziti'            => 10.90,
            'Smoked Mozzarella'     => 10.90,
            'Squash-Pepper'         =>  9.90,
            'Zucchini'              => 10.50,
            'Fig Squares'           => 12.90,
            'Cajun Shrimp'          =>  8.50,
            'Clam'                  => 12.90,
            'Bianco'                => 12.90,
            'Tomato Bianco'         => 12.90,
            'Bianco Mortadella'     => 12.90,
            'BBQ Chicken'           =>  7.90,
            'Verde'                 =>  9.90,
            'Onion-Corn'            => 10.50,
            'Onion-Bacon'           =>  9.90,
            'Onion-Ricotta'         =>  7.90,
            'Apple-Cheddar'         =>  8.50,
            'Bacon-Egg'             => 10.90,
            'Radicchio-Prosciutto'  => 10.90,
            'Pepper Lattice'        => 12.90,
            'Pissaladiere'          => 11.50,
            'Lamb-Feta'             => 10.50,
            'Ham-Brie'              => 12.90,
            'Wild Mushroom'         =>  7.90,
            'Artichoke'             =>  9.90,
            'Hawaiian'              => 10.90,
            'Fresh Veggie'          =>  8.50,
            'Potato-Rosemary'       =>  9.90,
            'Salad'                 => 11.50,
            'Salmon-Potato'         => 10.50,
            'Chicago'               => 10.90,
            'Grape-Stuffed'         =>  8.50,
            'Raisin-Stuffed'        => 11.50,
            'Banana-Chocolate'      => 12.90,
        ) as $name => $price) {

            $pizza = new Pizza();
            $pizza->setName($name);
            $pizza->setPrice($price);

            $manager->persist($pizza);
        }

        $manager->flush();
    }
}
