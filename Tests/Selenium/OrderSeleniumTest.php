<?php
namespace Acme\PizzaBundle\Tests\Selenium;

class OrderSeleniumTest extends AbstractSeleniumTest
{
    public function testPizza1Create()
    {
        $url = $this->router->generate('acmepizza_pizza_create');

        $this->open($url);
        $this->type("PizzaType_name", "Sicilian");
        $this->type("PizzaType_price", "11.50");
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad("30000");

        $this->assertTrue($this->isTextPresent("Sicilian"));
        $this->assertTrue($this->isTextPresent("11.50"));
    }

    public function testPizza1Update()
    {
        $url = $this->router->generate('acmepizza_pizza_list');

        $this->open($url);
        $this->click("//td[contains(text(), 'Sicilian')]/../td//a[text()='Update']");
        $this->waitForPageToLoad("30000");
        $this->type("PizzaType_name", "Big Sicilian");
        $this->type("PizzaType_price", "13.4");
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad("30000");

        $this->assertTrue($this->isTextPresent("Big Sicilian"));
        $this->assertTrue($this->isTextPresent("13.40"));
    }

    public function testOrder1Create()
    {
        $url = $this->router->generate('acmepizza_order_index');

        $this->open($url);
        $this->type("OrderFormType_address_name", "Arnaud Chassé");
        $this->type("OrderFormType_address_street", "17, rue de Lille");
        $this->type("OrderFormType_address_city", "62000 ARRAS");
        $this->type("OrderFormType_address_phone", "03.37.63.90.80");
        $this->select("OrderFormType_items_0_pizza", "label=Big Sicilian(13.4)");
        $this->type("OrderFormType_items_0_count", "1");
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad("30000");

        $this->assertTrue($this->isTextPresent("Arnaud Chassé"));
    }

    public function testPizza2Create()
    {
        $url = $this->router->generate('acmepizza_pizza_create');

        $this->open($url);
        $this->type("PizzaType_name", "Sweet Potato");
        $this->type("PizzaType_price", "7.90");
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad("30000");

        $this->assertTrue($this->isTextPresent("Sweet Potato"));
        $this->assertTrue($this->isTextPresent("7.90"));
    }

    public function testOrder2CreateWithKnowCustomer()
    {
        $url = $this->router->generate('acmepizza_order_index');

        $this->open($url);
        $this->select("OrderFormType_knownCustomer", "label=Yes");
        $this->type("OrderFormType_knownPhone", "03.37.63.90.80");
        $this->select("OrderFormType_items_0_pizza", "label=Sweet Potato(7.9)");
        $this->type("OrderFormType_items_0_count", "2");
        $this->click("link=Another pizza");
        $this->select("OrderFormType_items_1_pizza", "label=Big Sicilian(13.4)");
        $this->type("OrderFormType_items_1_count", "1");
        $this->click("//input[@type='submit']");
        $this->waitForPageToLoad("30000");

        $this->assertTrue($this->isTextPresent("Arnaud Chassé"));
    }

    /*
    public function testTitle()
    {
        $url = $this->router->generate('acmepizza_order_index');

        $this->open($url);
        $this->assertTitle('Symfony - Home');
    }
    */
}