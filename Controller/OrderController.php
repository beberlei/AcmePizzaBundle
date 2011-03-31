<?php

namespace Acme\PizzaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\PizzaBundle\Form\OrderFormType;

/**
 * @extra:Route("/pizza/order")
 */
class OrderController extends Controller
{
    /**
     * @extra:Route("/index", name="pizza_order_index")
     * @extra:Template()
     */
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

                return $this->redirect($this->generateUrl('pizza_order_list'));
            }
        }

        return array(
            'form' => $factory->createRenderer($orderForm, 'twig')
        );
    }

    /**
     * @extra:Route("/list", name="pizza_order_list")
     * @extra:Template()
     */
    public function listAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $orders = $em->getRepository('AcmePizza:Order')->findAll();

        return array(
            'orders' => $orders,
        );
    }
}
