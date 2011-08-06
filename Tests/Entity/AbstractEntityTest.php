<?php

namespace Acme\PizzaBundle\Tests\Entity;

abstract class AbstractEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\Validator\Validator
     */
    static protected $validator;

    public static function setUpBeforeClass()
    {
        require_once "{$_SERVER['KERNEL_DIR']}/AppKernel.php";

        $kernel = new \AppKernel('test', true);
        $kernel->boot();

        self::$validator = $kernel->getContainer()->get('validator');
    }
}
