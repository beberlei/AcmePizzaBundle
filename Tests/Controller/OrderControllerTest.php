<?php
// phpunit -c app src/Acme/PizzaBundle/Tests/Controller/
// phpunit --filter Create -c app src/Acme/PizzaBundle/Tests/Controller/

namespace Acme\PizzaBundle\Tests\Controller;

class OrderControllerTest extends AbstractControllerTest
{
    public function testCreate()
    {
        $this->markTestIncomplete();

        $url = $this->kernel->getContainer()
            ->get('router')
            ->generate('acmepizza_order_index')
            ;

        $client = $this->createClient();
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('POST', $url, array(
            'OrderFormType[knownCustomer]'   => 0,
            'OrderFormType[address][name]'   => 'Gilbert Archambault',
            'OrderFormType[address][street]' => '52, Chemin Du Lavarin Sud',
            'OrderFormType[address][city]'   => '14000 CAEN',
            'OrderFormType[address][phone]'  => '02.04.42.64.31',
            'OrderFormType[items][0][pizza]' => 14,                // 'Pepperoni(8.5)'
            'OrderFormType[items][0][count]' => 2,
        ));

        if ($client->getResponse()->getStatusCode() !== 302) {
            echo $crawler->text();
        }

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $this->markTestIncomplete();

        // updating form to add pizza fields like javscript would

        // filling the form
        $form = $crawler->filter("input[type='submit']")->form();

        $crawler = $client->submit($form);

        if ($client->getResponse()->getStatusCode() !== 302) {
            echo $crawler->text();
        }

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testCreeeate()
    {
        $this->markTestIncomplete();

        $url = $this->kernel->getContainer()
            ->get('router')
            ->generate('acmepizza_order_index')
            ;

        $client = $this->createClient();

        $client->request('POST', $url, array(
            'OrderFormType[knownCustomer]'   => 0,
            'OrderFormType[address][name]'   => 'Gilbert Archambault',
            'OrderFormType[address][street]' => '52, Chemin Du Lavarin Sud',
            'OrderFormType[address][city]'   => '14000 CAEN',
            'OrderFormType[address][phone]'  => '02.04.42.64.31',
            'OrderFormType[items][0][pizza]' => 14,                // 'Pepperoni(8.5)'
            'OrderFormType[items][0][count]' => 2,
        ));

        var_dump($client->getCrawler()->text());

        $this->assertEquals(302, $client->getResponse()->getStatusCode());



        $this->markTestIncomplete();

        $client = $this->createClient();
        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $node = $crawler->filter("div.order-pizza-prototype")->getNode(0);
        $xml = $node->ownerDocument->saveXML($node);

        $node = $crawler->filter("form")->getNode(0);
        // You use the DOMDocumentFragment objec to insert arbitrary HTML chunks into another document.
        $fragment = $node->ownerDocument->createDocumentFragment(); // create fragment
        $fragment->appendXML(str_replace('$$name$$', '0', $xml)); // insert arbitary html into the fragment
        //$node = // some operations to find whatever node you want to insert the fragment into
        $node->appendChild($fragment);

        /*
        $xml = $node->ownerDocument->saveXML($node);
        var_dump($xml);
        */
        /*
        $xml = str_replace('$$name$$', '0', $xml);
        var_dump($xml);
        */
        // http://php.net/manual/fr/class.domelement.php
        // $xml = $domElement->ownerDocument->saveXML($domElement);
        //$crawler->addHtmlContent();
        //$crawler->filter("form")->parents()->addHtmlContent("<h1>salut<h1>");
        /*
        function appendHTML(\DOMNode $parent, $source) {
            $tmpDoc = new \DOMDocument();
            $tmpDoc->loadHTML($source);
            foreach ($tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node) {
                $parent->ownerDocument->importNode($node);
                $parent->appendChild($node);
            }
        }
        $node = $crawler->filter("form")->getNode(0);
        $elem = $node->ownerDocument->createElement('div');
        appendHTML($elem, '<h1>Hello world</h1>');
        */
        /*
        $node = $crawler->filter("form")->parents()->getNode(0);
        $xml = $node->ownerDocument->saveXML($node);
        var_dump($xml);
        */
        //$crawler->filter("form")->xml() // TODO: PR
        /*
        $this->markTestIncomplete();
        $crawler->filter("form")->addContent(str_replace('$$name$$', '0', $xml));
        */

        $form = $crawler->filter("input[type='submit']")->form();

        $k = 'OrderFormType';

        $form["{$k}[knownCustomer]"]   = 0;

        $form["{$k}[address][name]"]   = 'Gilbert Archambault';
        $form["{$k}[address][street]"] = '52, Chemin Du Lavarin Sud';
        $form["{$k}[address][city]"]   = '14000 CAEN';
        $form["{$k}[address][phone]"]  = '02.04.42.64.31';

        $form["{$k}[items][0][pizza]"]->select(14); // 'Pepperoni(8.5)'
        $form["{$k}[items][0][count]"] = 2;
        /*
        $form["{$k}[items][1][pizza]"]->select(13);
        $form["{$k}[items][1][count]"] = 1;
        */

        /*
        $form["{$k}[items][0][pizza]"]->select(14); // 'Pepperoni(8.5)'
        $form["{$k}[items][0][count]"] = 2;

        $form[$k . '[items][$$name$$][pizza]']->select(14); // 'Pepperoni(8.5)'
        $form[$k . '[items][$$name$$][count]'] = 2;
        */

        //$$name$$

        $crawler = $client->submit($form);
        /*
        $this->markTestIncomplete();
        $crawler = $client->submit($form);
        */

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
