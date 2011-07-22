<?php

namespace Acme\PizzaBundle\Controller;

use
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template
;

/**
 * @Route("/acme-pizza/customer")
 */
class CustomerController extends Controller
{
    /**
     * @Route("/list", name="acmepizza_customer_list")
     * @Template()
     */
    public function listAction()
    {
        $customers = $this->getDoctrine()->getEntityManager()
            ->createQuery('SELECT c FROM AcmePizzaBundle:Customer c ORDER BY c.name ASC')
            ->getResult()
        ;

        return array('customers' => $customers);
    }
}
