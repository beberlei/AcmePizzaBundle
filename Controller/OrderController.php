<?php

namespace Acme\PizzaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderController extends Controller
{
    public function indexAction()
    {
        $order = new \Acme\PizzaBundle\Entity\Order();

        $factory = $this->get('form.factory');
        $form = $factory->create('Acme\PizzaBundle\Form\OrderFormType');
        $form->setData($order);

        xdebug_start_trace("/tmp/forms");
        $renderer = $form->getRenderer();
        $response = $this->render('AcmePizzaBundle:Order:index.html.twig', array(
            'form' => $renderer,
        ));
        \xdebug_stop_trace();
        return $response;
    }
}
