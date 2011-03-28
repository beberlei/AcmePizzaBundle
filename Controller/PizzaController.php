<?php

namespace Acme\PizzaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\PizzaBundle\Form\PizzaType;

class PizzaController extends Controller
{
    public function createAction()
    {
        $request = $this->get('request');
        $factory = $this->get('form.factory');
        /* @var $pizzaForm \Symfony\Component\Form\Form */
        $pizzaForm = $factory->create(new PizzaType());

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

        return $this->render('AcmePizza:Pizza:create.html.twig', array(
            'form' => $factory->createRenderer($pizzaForm, 'twig')
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
        $pizzaForm = $factory->create(new PizzaType());
        $pizzaForm->setData($pizza);

        if ($request->getMethod() == 'POST') {
            $pizzaForm->bindRequest($request);

            if ($pizzaForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('pizza_edit', array('id' => $pizza->getId())));
            }
        }

        return $this->render('AcmePizza:Pizza:edit.html.twig', array(
            'form' => $factory->createRenderer($pizzaForm, 'twig'),
            'pizza' => $pizza,
        ));
    }

    public function listAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $pizzas = $em->getRepository('AcmePizza:Pizza')->findAll();

        return $this->render('AcmePizza:Pizza:list.html.twig', array(
            'pizzas' => $pizzas,
        ));
    }
}