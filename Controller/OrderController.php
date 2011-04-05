<?php

namespace Acme\PizzaBundle\Controller;

use
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException
    ;

use
    Acme\PizzaBundle\Entity\OrderFactory,
    Acme\PizzaBundle\Entity\Pizza,
    Acme\PizzaBundle\Entity\PizzaItem,
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
/*
if (!true) {
        if (is_array($request->get('pizzas'))) {

            $ids = array_map(function($id) { return intval($id); }, $request->get('pizzas'));

            $pizzas = $em
                ->createQuery('SELECT p FROM AcmePizzaBundle:Pizza p WHERE p.id IN (' . implode(', ', $ids) .')')
                ->getResult()
                ;

            $items = array();

            foreach ($pizzas as $pizza) {
                $items[] = new PizzaItem($pizza);
            }

            $orderFactory->setItems($items);
        }
} else {
        $pizza = new Pizza();
        $pizza = $em->getRepository('AcmePizzaBundle:Pizza')->find(2);

        $items = array();
        for ($i = 0; $i < 3; $i++) {
            $items[] = new PizzaItem($pizza);
        }

        $orderFactory->setItems($items);
}
*/

        //var_dump(count($orderFactory->getItems()));

        //$orderFactory->createOrder();

        $factory = $this->get('form.factory');
        $form = $factory->create(new OrderFormType());
        $form->setData($orderFactory);

        if ($request->getMethod() == 'POST') {

            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->get('doctrine.orm.entity_manager');
                $em->persist($orderFactory->createOrder());
                $em->flush();

                return $this->redirect($this->generateUrl('pizza_order_list'));
            }
        }

        return array(
            'form' => $factory->createRenderer($form, 'twig')
        );
    }

    /**
     * @extra:Route("/list", name="pizza_order_list")
     * @extra:Template()
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
     * @extra:Route("/edit/{id}", name="pizza_order_edit")
     * @extra:Template()
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $order = $em->find('AcmePizzaBundle:Order', $id);
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
