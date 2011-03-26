<?php

namespace Acme\PizzaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PizzaController extends Controller
{
    public function createAction()
    {
        $request = $this->get('request');
        $factory = $this->get('form.factory');
        /* @var $pizzaForm \Symfony\Component\Form\Form */
        $pizzaForm = $factory->create('Acme\PizzaBundle\Form\PizzaType');

        $pizza = new \Acme\PizzaBundle\Entity\Pizza();
        $pizzaForm->setData($pizza);

        $validation = $this->get('validator');

        if ($request->getMethod() == 'POST') {
            $pizzaForm->bindRequest($request);

            if ($pizzaForm->isValid()) {
                $em = $this->get('doctrine.orm.entity_manager');
                $em->persist($pizza);
                $em->flush();

                return $this->redirect($this->generateUrl('pizza_list'));
            }
        }

        return $this->render('AcmePizzaBundle:Pizza:create.html.twig', array(
            'form' => $pizzaForm->getRenderer(),
        ));
    }

    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $pizza = $em->find('Acme\PizzaBundle\Entity\Pizza', $id);
        if (!$pizza) {
            throw new NotFoundHttpException("Invalid pizza.");
        }

        $request = $this->get('request');
        $factory = $this->get('form.factory');
        /* @var $pizzaForm \Symfony\Component\Form\Form */
        $pizzaForm = $factory->create('Acme\PizzaBundle\Form\PizzaType');
        $pizzaForm->setData($pizza);

        if ($request->getMethod() == 'POST') {
            $pizzaForm->bindRequest($request);

            if ($pizzaForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('pizza_edit', array('id' => $pizza->getId())));
            }
        }

        return $this->render('AcmePizzaBundle:Pizza:edit.html.twig', array(
            'form' => $pizzaForm->getRenderer(),
            'pizza' => $pizza,
        ));
    }

    public function listAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $pizzas = $em->getRepository('Acme\PizzaBundle\Entity\Pizza')->findAll();

        return $this->render('AcmePizzaBundle:Pizza:list.html.twig', array(
            'pizzas' => $pizzas,
        ));
    }
}