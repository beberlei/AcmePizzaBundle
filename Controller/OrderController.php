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

        $factory = $this->get('form.factory');
        $form = $factory->create(new OrderFormType());
        $form->setData($orderFactory);

        if ($request->getMethod() == 'POST') {

            $form->bindRequest($request);

/*
var_dump('post');
var_dump($form->getErrors());
var_dump($form->hasErrors());
var_dump($form->isBound());
var_dump(get_class($form));

foreach ($form->getChildren() as $child) {
//    var_dump($child->getErrors());
//    var_dump($form->isBound());
    //var_dump($form->hasErrors());
    //var_dump($child->isValid());
    echo $child->getName();

    if ($child->isValid() === false) {

        echo ">>>> pas valide!\n\n";
        foreach ($child->getChildren() as $c) {
            print_r(array(
                'name' => $child->getName(),
                'valid' => $child->isValid(),
                'errors' => $child->hasErrors(),
                'isbound' => $child->isBound(),
            ));

//            var_dump($child->isValid());
//            var_dump("bound", $child->isBound());
//            var_dump($child->hasErrors());
            foreach ($c->getChildren() as $c0) {
                var_dump($c0->isValid());
                echo "children";
            }
        }
    }

    echo "\n\n";
}
*/
//var_dump(get_class_methods(get_class($form)));

            if ($form->isValid()) {

                $em = $this->get('doctrine.orm.entity_manager');
                $em->persist($orderFactory->createOrder());
                $em->flush();

                return $this->redirect($this->generateUrl('pizza_order_list'));
            }
        }
//exit();
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
