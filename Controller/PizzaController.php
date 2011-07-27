<?php

namespace Acme\PizzaBundle\Controller;

use
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template
;

use
    Acme\PizzaBundle\Entity\Pizza,
    Acme\PizzaBundle\Form\Type\PizzaType
;

/**
 * @Route("/pizza")
 */
class PizzaController extends Controller
{
    /**
     * @Route("/create", name="acme_pizza_pizza_create"),
     * @Route("/update/{id}", name="acme_pizza_pizza_update", requirements={"id" = "\d+"})
     * @Template()
     */
    public function editAction($id = null)
    {
        $em = $this->getDoctrine()->getEntityManager();

        if (isset($id)) {
            $pizza = $em->find('AcmePizzaBundle:Pizza', $id);

            if (!$pizza) {
                throw new NotFoundHttpException("Invalid pizza.");
            }
        } else {
            $pizza = new Pizza();
        }

        $form = $this->createForm(new PizzaType(), $pizza);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($pizza);
                $em->flush();

                $this->get('session')->setFlash('success', 'New pizza was saved!');

                return $this->redirect($this->generateUrl('acme_pizza_pizza_list'));
            }
        }

        return array(
            'form'  => $form->createView(),
            'pizza' => $pizza,
        );
    }

    /**
     * @Route("/list")
     * @Template()
     */
    public function listAction()
    {
        $pizzas = $this->get('doctrine')->getEntityManager()
            ->createQuery('SELECT p FROM AcmePizzaBundle:Pizza p ORDER BY p.name ASC')
            ->getResult()
        ;

        return array('pizzas' => $pizzas);
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $pizza = $em->find('AcmePizzaBundle:Pizza', $id);

        if (!$pizza) {
            throw new NotFoundHttpException("Invalid pizza.");
        }

        $em->remove($pizza);
        $em->flush();

        return $this->redirect($this->generateUrl('acme_pizza_pizza_list'));
    }
}
