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

        $url = $this->router->generate('acme_pizza_pizza_create');

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
            'price' => 13.4,
        );

        $url = $this->router->generate('acme_pizza_pizza_list');

        $this->open($url);
        $this->click("//td[contains(text(), 'Sicilian')]/../td//a[text()='Update']");
        $this->waitForPageToLoad(30000);
        $this->type('pizza_name',  $pizza['name']);
        $this->type('pizza_price', $pizza['price']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent($pizza['name' ]));
        $this->assertTrue($this->isTextPresent($pizza['price']));
    }

    public function testOrder1Create()
    {
        $order = array(
            'customer' => array(
                'name'   => 'Arnaud Chassé',
                'street' => '17, rue de Lille',
                'city'   => '62000 ARRAS',
                'phone'  => '03.37.63.90.80',
            ),
            'items' => array(
                array(
                    'pizza' => 'Big Sicilian(13.40)',
                    'count' => 1,
                ),
            ),
        );

        $url = $this->router->generate('acme_pizza_order_index');

        $this->open($url);
        $this->type  ('order_customer_name',   $order['customer']['name'  ]);
        $this->type  ('order_customer_street', $order['customer']['street']);
        $this->type  ('order_customer_city',   $order['customer']['city'  ]);
        $this->type  ('order_customer_phone',  $order['customer']['phone' ]);
        $this->select('order_items_0_pizza',  'label='.$order['items'][0]['pizza']);
        $this->type  ('order_items_0_count',  $order['items'][0]['count']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertTrue($this->isTextPresent($order['customer']['name'  ]));
        $this->assertTrue($this->isTextPresent($order['customer']['street']));
        $this->assertTrue($this->isTextPresent($order['customer']['city'  ]));
        $this->assertTrue($this->isTextPresent($order['customer']['phone' ]));
        foreach($order['items'] as $item) {
            //$this->assertTrue($this->isTextPresent($item['pizza']));
            $this->assertTrue($this->isTextPresent($item['count']));
        }
    }

    public function testPizza2Create()
    {
        $pizza = array(
            'name'  => 'Sweet Potato',
            'price' => 7.9
        );

        $url = $this->router->generate('acme_pizza_pizza_create');

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
                    'pizza' => 'Sweet Potato(7.90)',
                    'count' => 2,
                ),
                array(
                    'pizza' => 'Big Sicilian(13.40)',
                    'count' => 1,
                ),
            ),
        );

        $url = $this->router->generate('acme_pizza_order_index');

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
                    'pizza' => 'Sweet Potato(7.90)',
                    'count' => 3,
                ),
            ),
        );

        $url = $this->router->generate('acme_pizza_order_index');

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
                    'pizza' => 'Sweet Potato(7.90)',
                    'count' => 0,
                ),
            ),
        );

        $url = $this->router->generate('acme_pizza_order_index');

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
        $order = array(
            'known_phone' => '03.37.63.90.80',
            'items' => array(
                array(
                    'pizza' => 'Sweet Potato(7.90)',
                    'count' => -1,
                ),
            ),
        );

        $url = $this->router->generate('acme_pizza_order_index');

        $this->open($url);
        $this->click ('order_known_customer');
        $this->type  ('order_known_phone', $order['known_phone']);
        $this->select('order_items_0_pizza', 'label='.$order['items'][0]['pizza']);
        $this->type  ('order_items_0_count', $order['items'][0]['count']);
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->markTestSkipped();

        $this->assertTrue($this->isTextPresent("You have to pick at least one pizza..."));
    }

    public function testOrderUpdateCustomer()
    {
        $url = $this->router->generate('acme_pizza_order_edit', array('id' => 6));

        $this->open($url);

        if ('Madeleine Thibault' == $this->getValue('order_customer_name')) {
            $data = array(
                'order_customer_name'   => 'Madeleine Thibault',
                'order_customer_street' => '3, rue des Lacs',
                'order_customer_city'   => '14200 HÉROUVILLE-SAINT-CLAIR',
                'order_customer_phone'  => '02.12.62.54.75',
            );
        } else {
            $data = array(
                'order_customer_name'   => 'Andreas Zimmerman',
                'order_customer_street' => 'Lietzenburger Strasse 75',
                'order_customer_city'   => '51469 Bergisch Gladbach Hand',
                'order_customer_phone'  => '02202 01 48 77',
            );
        }

        foreach ($data as $key => $value) {
            $this->type($key, $value);
        }

        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        foreach ($data as $key => $value) {
            $this->assertTrue($this->isTextPresent($value));
        }
    }

    public function testOrderUpdatePizzaCount()
    {
        $url = $this->router->generate('acme_pizza_order_edit', array('id' => 6));

        $this->open($url);

        $counts = array();

        for ($i = 0; $i < $this->getXpathCount('//tbody/tr'); $i++) {
            $counts[] = $count = rand(100, 999);

            $this->type("order_items_{$i}_count", $count);
        }

        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        foreach ($counts as $i => $count) {
            $this->assertEquals($count, $this->getText('//tbody/tr['.($i + 1).']/td[2]'));
        }
    }

    public function testOrderUpdatePizzaType()
    {
        $url = $this->router->generate('acme_pizza_order_edit', array('id' => 6));

        $this->open($url);

        $n = $this->getXpathCount('//select[@id="order_items_0_pizza"]/option');

        $pizzas = array();

        for ($i = 0; $i < $this->getXpathCount('//tbody/tr'); $i++) {
            $pizzas[] = $pizza = $this->getText('//select[@id="order_items_0_pizza"]/option['.rand(1, $n).']');

            $this->select("order_items_{$i}_pizza", 'label='.$pizza);
        }

        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        foreach ($pizzas as $i => $pizza) {
            $pizza = substr($pizza, 0, strpos($pizza, '('));
            $this->assertEquals($pizza, $this->getText('//tbody/tr['.($i + 1).']/td[1]'));
        }
    }

    public function testOrderUpdatePizzaAdd()
    {
        $url = $this->router->generate('acme_pizza_order_edit', array('id' => 6));

        $this->open($url);

        $n = $this->getXpathCount('//tbody/tr');

        $this->click('//tbody/tr[position()=last()]//a[text()="Add"]');

        $pizza = $this->getText(sprintf('//select[@id="order_items_0_pizza"]/option[%d]', rand(
            1,
            $this->getXpathCount('//select[@id="order_items_0_pizza"]/option')
        )));

        $this->select("order_items_{$n}_pizza", 'label='.$pizza);
        $this->type("order_items_{$n}_count", $count = rand(100, 999));

        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertEquals($n + 1, $this->getXpathCount('//tbody/tr'));

        $pizza = substr($pizza, 0, strpos($pizza, '('));
        $this->assertEquals($pizza, $this->getText('//tbody/tr[position()=last()]/td[1]'));
        $this->assertEquals($count, $this->getText('//tbody/tr[position()=last()]/td[2]'));
    }

    public function testOrderUpdatePizzaRemove()
    {
        $url = $this->router->generate('acme_pizza_order_edit', array('id' => 6));

        $this->open($url);

        $n = $this->getXpathCount('//tbody/tr');

        $this->click('//tbody/tr[position()=last()]//a[text()="Remove"]');

        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad(30000);

        $this->assertEquals($n - 1, $this->getXpathCount('//tbody/tr'));
    }
}
