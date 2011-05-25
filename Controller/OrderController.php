<?php

namespace Acme\PizzaBundle\Controller;

use
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra
    ;

use
    Acme\PizzaBundle\Entity\Factory\OrderFactory,
    Acme\PizzaBundle\Entity\Order,
    Acme\PizzaBundle\Form\OrderFormType
    ;

/**
 * @Extra\Route("/acme-pizza/order")
 */
class OrderController extends Controller
{
    /**
     * @Extra\Route("/index", name="acmepizza_order_index")
     * @Extra\Template()
     */
    public function indexAction()
    {
        $request = $this->get('request');
        $em = $this->get('doctrine.orm.entity_manager');

        $factory = new OrderFactory($em);

        $form = $this->get('form.factory')->create(new OrderFormType());
        $form->setData($factory);

        if ($request->getMethod() == 'POST') {

            //$form->setValidationGroups('new');

            $form->bindRequest($request);

            if ($form->isValid()) {

                //$em = $this->get('doctrine.orm.entity_manager');
                $em->persist($factory->make());
                $em->flush();

                return $this->redirect($this->generateUrl('acmepizza_order_list'));
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @Extra\Route("/list", name="acmepizza_order_list")
     * @Extra\Template()
     */
    public function listAction()
    {
        $orders = $this->get('doctrine.orm.entity_manager')
            ->createQuery('SELECT o FROM AcmePizzaBundle:Order o ORDER BY o.id DESC')
            ->getResult()
            ;

        return array(
            'orders' => $orders,
        );
    }

    /**
     * @Extra\Route("/edit/{id}", name="acmepizza_order_edit")
     * @Extra\Template()
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $order = $em->find('AcmePizzaBundle:Order', $id);
        /* @var \Acme\PizzaBundle\Entity\Order $order */
        if (!$order) {
            throw new NotFoundHttpException("Invalid Order.");
        }

        $form = $this->get('form.factory')->create(new OrderType());
        $form->setData($order);

        if ($this->get('request')->getMethod() == 'POST') {

            $form->bindRequest($this->get('request'));

            if ($form->isValid()) {

                $em->flush();

                return $this->redirect($this->generateUrl('acmepizza_order_edit', array(
                    'id' => $order->getId(),
                )));
            }
        }

        return array(
            'form'  => $form->createView(),
            'order' => $order,
        );
    }
}
