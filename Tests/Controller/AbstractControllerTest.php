<?php
namespace Acme\PizzaBundle\Tests\Controller;

use
    Symfony\Bundle\FrameworkBundle\Test\WebTestCase
    ;

use
    Symfony\Bundle\FrameworkBundle\Console\Application,
    Symfony\Component\Console\Input\ArrayInput
    ;

abstract class AbstractControllerTest extends WebTestCase
{
    protected $kernel;
    protected $em;

    public function setUp()
    {
        parent::setUp();

        $this->kernel = $this->createKernel();
        $this->kernel->boot();

        $application = new Application($this->kernel);
        $application->setAutoExit(false);
        $application->run(new ArrayInput(array('command' => 'doctrine:schema:drop', '--force' => true)));
        $application->run(new ArrayInput(array('command' => 'doctrine:schema:create')));
        $application->run(new ArrayInput(array('command' => 'doctrine:data:load', '--fixtures' => 'src/Acme/PizzaBundle/DataFixtures/ORM/')));

        $this->em = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
}
