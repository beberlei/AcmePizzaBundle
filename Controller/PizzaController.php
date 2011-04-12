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
     * @extra:Routes({
     *     @extra:Route("/create", name="acmepizza_pizza_create"),
     *     @extra:Route("/update/{id}", name="acmepizza_pizza_update", requirements={"id" = "\d+"})
     * })
     * @extra:Template()
     */
    public function editAction($id = null)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        if (isset($id)) {
            $pizza = $em->find('AcmePizzaBundle:Pizza', $id);

            if (!$pizza) {
                throw new NotFoundHttpException("Invalid pizza.");
            }
        } else {
            $pizza = new Pizza();
        }

        $form = $this->get('form.factory')->create(new PizzaType());
        $form->setData($pizza);

        if ($this->get('request')->getMethod() == 'POST') {
            $form->bindRequest($this->get('request'));

            if ($form->isValid()) {
                $em->persist($pizza);
                $em->flush();

                return $this->redirect($this->generateUrl('acmepizza_pizza_list'));
            }
        }

        return array(
            'form'  => $this->get('form.factory')->createRenderer($form, 'twig'),
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
