<?php

namespace Acme\PizzaBundle\Controller;

use
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException
    ;

use
    Acme\PizzaBundle\Entity\Pizza,
    Acme\PizzaBundle\Form\Type\PizzaType
    ;

/**
 * @extra:Route("/acme-pizza/pizza")
 */
class PizzaController extends Controller
{
    /**
     * @extra:Route("/create", name="acmepizza_pizza_create")
     * @extra:Template()
     */
    public function createAction()
    {
        $request = $this->get('request');
        $factory = $this->get('form.factory');
        /* @var $pizzaForm \Symfony\Component\Form\Form */
        $form = $factory->create(new PizzaType());

        $pizza = new Pizza();
        $form->setData($pizza);

        $validation = $this->get('validator');

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->get('doctrine.orm.entity_manager');
                $em->persist($pizza);
                $em->flush();

                return $this->redirect($this->generateUrl('acmepizza_pizza_list'));
            }
        }

        return array(
            'form' => $factory->createRenderer($form, 'twig')
        );
    }

    /**
     * @extra:Route("/edit/{id}", name="acmepizza_pizza_edit")
     * @extra:Template()
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $pizza = $em->find('AcmePizzaBundle:Pizza', $id);
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

                return $this->redirect($this->generateUrl('acmepizza_pizza_list'));
            }
        }

        return array(
            'form'  => $factory->createRenderer($form, 'twig'),
            'pizza' => $pizza,
        );
    }

    /**
     * @extra:Route("/list", name="acmepizza_pizza_list")
     * @extra:Template()
     */
    public function listAction()
    {
        $pizzas = $this->get('doctrine.orm.entity_manager')
            ->createQuery('SELECT p FROM AcmePizzaBundle:Pizza p ORDER BY p.name ASC')
            ->getResult()
            ;

        return array(
            'pizzas' => $pizzas,
        );
    }

    /**
     * @extra:Route("/delete/{id}", name="acmepizza_pizza_delete")
     * @extra:Template()
     */
    public function deleteAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $pizza = $em->find('AcmePizzaBundle:Pizza', $id);

        if (!$pizza) {
            throw new NotFoundHttpException("Invalid pizza.");
        }

        $em->remove($pizza);
        $em->flush();

        return $this->redirect($this->generateUrl('acmepizza_pizza_list'));
    }
}
