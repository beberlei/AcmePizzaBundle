<?php

namespace Acme\PizzaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\PizzaBundle\Form\OrderFormType;

class OrderController extends Controller
{
    public function indexAction()
    {
        $request = $this->get('request');
        $em = $this->get('doctrine.orm.entity_manager');
        $orderFactory = new \Acme\PizzaBundle\Entity\OrderFactory($em);

        $factory = $this->get('form.factory');
        $orderForm = $factory->create(new OrderFormType());
        $orderForm->setData($orderFactory);

        if ($request->getMethod() == 'POST') {
            $orderForm->bindRequest($request);

            if ($orderForm->isValid()) {
                $em = $this->get('doctrine.orm.entity_manager');
                $em->persist($orderFactory->createOrder());
                $em->flush();

                return $this->redirect($this->generateUrl('pizza_list'));
            }
        }

        return $this->render('AcmePizzaBundle:Order:index.html.twig', array(
            'form' => $factory->createRenderer($orderForm, 'twig')
        ));
    }
}
