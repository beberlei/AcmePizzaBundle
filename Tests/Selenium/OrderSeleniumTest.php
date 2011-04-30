<?php
namespace Acme\PizzaBundle\Tests\Selenium;

class OrderSeleniumTest extends AbstractSeleniumTest
{
    public function testPizza1Create()
    {
        $pizza = array(
            'name'  => 'Sicilian',
            'price' => 11.5
        );

        $url = $this->router->generate('acmepizza_pizza_create');

        $this->open($url);
        $this->type('pizza_name',  $pizza['name' ]);
        $this->type('pizza_price', $pizza['price']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent($pizza['name' ]));
        $this->assertTrue($this->isTextPresent($pizza['price']));
    }

    public function testPizza1Update()
    {
        $pizza = array(
            'name'  => 'Big Sicilian',
            'price' => 13.4
        );

        $url = $this->router->generate('acmepizza_pizza_list');

        $this->open($url);
        $this->click("//td[contains(text(), 'Sicilian')]/../td//a[text()='Update']");
        $this->waitForPageToLoad(30000);
        $this->type('pizza_name',  $pizza['name' ]);
        $this->type('pizza_price', $pizza['price']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent($pizza['name' ]));
        $this->assertTrue($this->isTextPresent($pizza['price']));
    }

    public function testOrder1Create()
    {
        $order = array(
            'address' => array(
                'name'   => 'Arnaud Chassé',
                'street' => '17, rue de Lille',
                'city'   => '62000 ARRAS',
                'phone'  => '03.37.63.90.80',
            ),
            'items' => array(
                array(
                    'pizza' => 'Big Sicilian(13.4)',
                    'count' => 1,
                ),
            ),
        );

        $url = $this->router->generate('acmepizza_order_index');

        $this->open($url);
        $this->type  ('order_address_name',   $order['address']['name'  ]);
        $this->type  ('order_address_street', $order['address']['street']);
        $this->type  ('order_address_city',   $order['address']['city'  ]);
        $this->type  ('order_address_phone',  $order['address']['phone' ]);
        $this->select('order_items_0_pizza',  'label='.$order['items'][0]['pizza']);
        $this->type  ('order_items_0_count',  $order['items'][0]['count']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent($order['address']['name']));
    }

    public function testPizza2Create()
    {
        $pizza = array(
            'name'  => 'Sweet Potato',
            'price' => 7.9
        );

        $url = $this->router->generate('acmepizza_pizza_create');

        $this->open($url);
        $this->type('pizza_name',  $pizza['name' ]);
        $this->type('pizza_price', $pizza['price']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent($pizza['name' ]));
        $this->assertTrue($this->isTextPresent($pizza['price']));
    }

    public function testOrder2CreateWithKnowCustomer()
    {
        $order = array(
            'known_phone' => '03.37.63.90.80',
            'items' => array(
                array(
                    'pizza' => 'Sweet Potato(7.9)',
                    'count' => 2,
                ),
                array(
                    'pizza' => 'Big Sicilian(13.4)',
                    'count' => 1,
                ),
            ),
        );

        $url = $this->router->generate('acmepizza_order_index');

        $this->open($url);
        $this->click ('order_known_customer');
        $this->type  ('order_known_phone', $order['known_phone']);
        $this->select('order_items_0_pizza', 'label='.$order['items'][0]['pizza']);
        $this->type  ('order_items_0_count', $order['items'][0]['count']);
        $this->click ('link=Add');
        $this->select('order_items_1_pizza', 'label='.$order['items'][1]['pizza']);
        $this->type  ('order_items_1_count', $order['items'][1]['count']);
        $this->click ("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent("Arnaud Chassé"));
    }

    public function testOrder3CreateWithKnowCustomerButTypoInPhoneNumber()
    {
        $order = array(
            'known_phone' => '03.37.63.90.70',
            'items' => array(
                array(
                    'pizza' => 'Sweet Potato(7.9)',
                    'count' => 3,
                ),
            ),
        );

        $url = $this->router->generate('acmepizza_order_index');

        $this->open($url);
        $this->click ('order_known_customer');
        $this->type  ('order_known_phone', $order['known_phone']);
        $this->select('order_items_0_pizza', 'label='.$order['items'][0]['pizza']);
        $this->type  ('order_items_0_count', $order['items'][0]['count']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent("Phone number is not registered"));
    }

    public function testOrder4CreateWithKnowCustomerButCountIsZero()
    {
        $order = array(
            'known_phone' => '03.37.63.90.80',
            'items' => array(
                array(
                    'pizza' => 'Sweet Potato(7.9)',
                    'count' => 0,
                ),
            ),
        );

        $url = $this->router->generate('acmepizza_order_index');

        $this->open($url);
        $this->click ('order_known_customer');
        $this->type  ('order_known_phone', $order['known_phone']);
        $this->select('order_items_0_pizza', 'label='.$order['items'][0]['pizza']);
        $this->type  ('order_items_0_count', $order['items'][0]['count']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent("You have to pick at least one pizza..."));
    }

    public function testOrder5CreateWithKnowCustomerButCountIsNegative()
    {
        $this->markTestSkipped();

        $order = array(
            'known_phone' => '03.37.63.90.80',
            'items' => array(
                array(
                    'pizza' => 'Sweet Potato(7.9)',
                    'count' => -1,
                ),
            ),
        );

        $url = $this->router->generate('acmepizza_order_index');

        $this->open($url);
        $this->click ('order_known_customer');
        $this->type  ('order_known_phone', $order['known_phone']);
        $this->select('order_items_0_pizza', 'label='.$order['items'][0]['pizza']);
        $this->type  ('order_items_0_count', $order['items'][0]['count']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent("You have to pick at least one pizza..."));
    }
}
