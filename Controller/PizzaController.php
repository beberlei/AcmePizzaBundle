<?php

namespace Acme\PizzaBundle\Controller;

use
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException
    ;

use Acme\PizzaBundle\Form\PizzaType;

/**
 * @extra:Route("/pizza/pizza")
 */
class PizzaController extends Controller
{
    /**
     * @extra:Route("/create", name="pizza_pizza_create")
     * @extra:Template()
     */
    public function createAction()
    {
        $request = $this->get('request');
        $factory = $this->get('form.factory');
        /* @var $pizzaForm \Symfony\Component\Form\Form */
        $form = $factory->create(new PizzaType());

        $pizza = new \Acme\PizzaBundle\Entity\Pizza();
        $form->setData($pizza);

        $validation = $this->get('validator');

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->get('doctrine.orm.entity_manager');
                $em->persist($pizza);
                $em->flush();

                return $this->redirect($this->generateUrl('pizza_pizza_list'));
            }
        }

        return array(
            'form' => $factory->createRenderer($form, 'twig')
        );
    }

    /**
     * @extra:Route("/edit/{id}", name="pizza_pizza_edit")
     * @extra:Template()
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $pizza = $em->find('AcmePizza:Pizza', $id);
        if (!$pizza) {
            throw new NotFoundHttpException("Invalid pizza.");
        }

        $request = $this->get('request');
        $factory = $this->get('form.factory');
        /* @var $pizzaForm \Symfony\Component\Form\Form */
        $form = $factory->create(new PizzaType());
        $form->setData($pizza);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('pizza_pizza_edit', array('id' => $pizza->getId())));
            }
        }

        return array(
            'form'  => $factory->createRenderer($form, 'twig'),
            'pizza' => $pizza,
        );
    }

    /**
     * @extra:Route("/list", name="pizza_pizza_list")
     * @extra:Template()
     */
    public function listAction()
    {
        $pizzas = $this->get('doctrine.orm.entity_manager')
            ->createQuery('SELECT p FROM AcmePizza:Pizza p ORDER BY p.name ASC')
            ->getResult()
            ;

        return array(
            'pizzas' => $pizzas,
        );
    }
}