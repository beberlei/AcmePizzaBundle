<?php

namespace Acme\PizzaBundle\Controller;

use
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException
    ;

use
    Acme\PizzaBundle\Entity\OrderFactory,
    Acme\PizzaBundle\Form\OrderFormType,
    Acme\PizzaBundle\Form\OrderType
    ;

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

        $orderFactory = new OrderFactory($em);

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

    /**
     * @extra:Route("/edit/{id}", name="pizza_order_edit")
     * @extra:Template()
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $order = $em->find('AcmePizza:Order', $id);
        if (!$order) {
            throw new NotFoundHttpException("Invalid Order.");
        }

        $form = $this->get('form.factory')->create(new OrderType());
        $form->setData($order);

        if ($this->get('request')->getMethod() == 'POST') {

            $form->bindRequest($this->get('request'));

            if ($form->isValid()) {

                $em->flush();

                return $this->redirect($this->generateUrl('pizza_order_edit', array('id' => $pizza->getId())));
            }
        }

        return array(
            'form'  => $this->get('form.factory')->createRenderer($form, 'twig'),
            'order' => $order,
        );
    }
}
