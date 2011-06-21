<?php

namespace Acme\PizzaBundle\Controller;

use
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra
    ;

/**
 * @Extra\Route("/acme-pizza/customer")
 */
class CustomerController extends Controller
{
    /**
     * @Extra\Route("/list", name="acmepizza_customer_list")
     * @Extra\Template()
     */
    public function listAction()
    {
        $customers = $this->get('doctrine')->getEntityManager()
            ->createQuery('SELECT c FROM AcmePizzaBundle:Customer c ORDER BY c.name ASC')
            ->getResult()
            ;

        return array(
            'customers' => $customers,
        );
    }
}
