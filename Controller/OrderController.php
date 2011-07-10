<?php

namespace Acme\PizzaBundle\Controller;

use
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template
    ;

use
    Acme\PizzaBundle\Entity\Factory\OrderFactory,
    Acme\PizzaBundle\Entity\Order,
    Acme\PizzaBundle\Form\OrderFormType
    ;

/**
 * @Route("/acme-pizza/order")
 */
class OrderController extends Controller
{
    /**
     * @Route("/index", name="acmepizza_order_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->get('doctrine')->getEntityManager();
        /* @var $em Doctrine\ORM\EntityManager */

        $factory = new OrderFactory($em);

        $form = $this->createForm(new OrderFormType(), $factory);

        $request = $this->get('request');
        /* @var $request Symfony\Component\HttpFoundation\Request */

        if ($request->getMethod() == 'POST') {

            $form->bindRequest($request);

            if ($form->isValid()) {

                $em->persist($factory->make());
                $em->flush();

                return $this->redirect($this->generateUrl('acmepizza_order_list'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/list", name="acmepizza_order_list")
     * @Template()
     */
    public function listAction()
    {
        $orders = $this->get('doctrine')->getEntityManager()
            ->createQuery('SELECT o FROM AcmePizzaBundle:Order o ORDER BY o.id DESC')
            ->getResult()
            ;

        return array(
            'orders' => $orders,
        );
    }

    /**
     * @Route("/edit/{id}", name="acmepizza_order_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine')->getEntityManager();

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
