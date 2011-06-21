<?php

namespace Acme\PizzaBundle\Controller;

use
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra
    ;

use
    Acme\PizzaBundle\Entity\Pizza,
    Acme\PizzaBundle\Form\Type\PizzaType
    ;

/**
 * @Extra\Route("/acme-pizza/pizza")
 */
class PizzaController extends Controller
{
    /**
     * @Extra\Route("/create", name="acmepizza_pizza_create"),
     * @Extra\Route("/update/{id}", name="acmepizza_pizza_update", requirements={"id" = "\d+"})
     * @Extra\Template()
     */
    public function editAction($id = null)
    {
        $em = $this->get('doctrine')->getEntityManager();
        /* @var $em Doctrine\ORM\EntityManager */

        if (isset($id)) {
            $pizza = $em->find('AcmePizzaBundle:Pizza', $id);

            if (!$pizza) {
                throw new NotFoundHttpException("Invalid pizza.");
            }
        } else {
            $pizza = new Pizza();
        }

        $form = $this->createForm(new PizzaType(), $pizza);

        $request = $this->get('request');
        /* @var $request Symfony\Component\HttpFoundation\Request */

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($pizza);
                $em->flush();

                return $this->redirect($this->generateUrl('acmepizza_pizza_list'));
            }
        }

        return array(
            'form'  => $form->createView(),
            'pizza' => $pizza,
        );
    }

    /**
     * @Extra\Route("/list", name="acmepizza_pizza_list")
     * @Extra\Template()
     */
    public function listAction()
    {
        $pizzas = $this->get('doctrine')->getEntityManager()
            ->createQuery('SELECT p FROM AcmePizzaBundle:Pizza p ORDER BY p.name ASC')
            ->getResult()
            ;

        return array(
            'pizzas' => $pizzas,
        );
    }

    /**
     * @Extra\Route("/delete/{id}", name="acmepizza_pizza_delete")
     * @Extra\Template()
     */
    public function deleteAction($id)
    {
        $em = $this->get('doctrine')->getEntityManager();

        $pizza = $em->find('AcmePizzaBundle:Pizza', $id);

        if (!$pizza) {
            throw new NotFoundHttpException("Invalid pizza.");
        }

        $em->remove($pizza);
        $em->flush();

        return $this->redirect($this->generateUrl('acmepizza_pizza_list'));
    }
}
