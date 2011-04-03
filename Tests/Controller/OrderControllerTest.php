<?php
// phpunit -c app src/Acme/PizzaBundle/Tests/Controller/
// phpunit --filter Create -c app src/Acme/PizzaBundle/Tests/Controller/

namespace Acme\PizzaBundle\Tests\Controller;

class OrderControllerTest extends AbstractControllerTest
{
    public function testCreate()
    {
        $url = $this->kernel->getContainer()
            ->get('router')
            ->generate('pizza_order_index')
            ;

        $client = $this->createClient();
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->filter("input[type='submit']")->form();

        $k = 'OrderFormType';
        
        $form["{$k}[knownCustomer]"]   = 0;
        
        $form["{$k}[address][name]"]   = 'Gilbert Archambault';
        $form["{$k}[address][street]"] = '52, Chemin Du Lavarin Sud';
        $form["{$k}[address][city]"]   = '14000 CAEN';
        $form["{$k}[address][phone]"]  = '02.04.42.64.31';

        $form["{$k}[items][0][pizza]"]->select(14); // 'Pepperoni(8.5)'
        $form["{$k}[items][0][count]"] = 2;
        
        $form["{$k}[items][1][pizza]"]->select(13);
        $form["{$k}[items][1][count]"] = 1;
        
        /*
        $form["{$k}[items][0][pizza]"]->select(14); // 'Pepperoni(8.5)'
        $form["{$k}[items][0][count]"] = 2;

        $form[$k . '[items][$$name$$][pizza]']->select(14); // 'Pepperoni(8.5)'
        $form[$k . '[items][$$name$$][count]'] = 2;
        */

        //$$name$$

        $crawler = $client->submit($form);
        
        $crawler = $client->submit($form);

        if ($client->getResponse()->getStatusCode() !== 302) {
            echo $crawler->text();
        }

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        //$this->markTestIncomplete();
    }

    public function testUpdate()
    {
        $this->markTestIncomplete();
    }
}
