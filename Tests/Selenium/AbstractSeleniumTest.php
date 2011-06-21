<?php
namespace Acme\PizzaBundle\Tests\Selenium;

use
    Symfony\Bundle\FrameworkBundle\Console\Application,
    Symfony\Component\Console\Input\ArrayInput
    ;

abstract class AbstractSeleniumTest extends \PHPUnit_Extensions_SeleniumTestCase //WebTestCase
{
    protected $kernel;
    protected $router;
    //protected $em;

    protected function setUp()
    {
        parent::setUp();

        require_once "{$_SERVER['KERNEL_DIR']}/AppKernel.php";

        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();

        $this->router = $this->kernel->getContainer()->get('router');
        $this->router->getContext()->setHost($_SERVER['HTTP_HOST']);
        $this->router->getContext()->setBaseUrl($_SERVER['SCRIPT_NAME']);

        $this->setBrowserUrl("http://{$_SERVER['HTTP_HOST']}");
        //$this->setSleep(1);

        /*
        $application = new Application($this->kernel);
        $application->setAutoExit(false);
        $application->run(new ArrayInput(array('command' => 'doctrine:schema:drop', '--force' => true)));
        $application->run(new ArrayInput(array('command' => 'doctrine:schema:create')));
        $application->run(new ArrayInput(array('command' => 'doctrine:data:load', '--fixtures' => 'src/Acme/PizzaBundle/DataFixtures/ORM/')));

        $this->em = $this->kernel->getContainer()->get('doctrine')->getEntityManager();
        */
    }
}
