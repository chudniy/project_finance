<?php

namespace FinanceBundle\Controller;

use FinanceBundle\Entity\Refill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * Refill controller.
 *
 */
class RefillController extends Controller
{
    /**
     * Lists all refill entities.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $refills = $em->getRepository('FinanceBundle:Refill')->refillByRequest($request);

        return $this->render('FinanceBundle:refill:index.html.twig', array(
            'refills' => $refills,
        ));
    }

    /**
     * Creates a new refill entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $refill = new Refill();
        $form = $this->createForm('FinanceBundle\Form\RefillType', $refill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($refill);
                $em->flush();
            } catch (Exception $e) {
                return $this->render('FinanceBundle:refill:new.html.twig', array(
                    'refill' => $refill,
                    'form' => $form->createView(),
                    'error' => $e->getMessage(),
                ));
            }


            return $this->redirectToRoute('refill_show', array('id' => $refill->getId()));
        }

        return $this->render('FinanceBundle:refill:new.html.twig', array(
            'refill' => $refill,
            'form' => $form->createView(),
            'error' => '',
        ));
    }

    /**
     * Finds and displays a refill entity.
     * @param Refill $refill
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Refill $refill)
    {
        $deleteForm = $this->createDeleteForm($refill);

        return $this->render('FinanceBundle:refill:show.html.twig', array(
            'refill' => $refill,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing refill entity.
     * @param Request $request
     * @param Refill $refill
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Refill $refill)
    {
        $deleteForm = $this->createDeleteForm($refill);
        $editForm = $this->createForm('FinanceBundle\Form\RefillType', $refill);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('refill_edit', array('id' => $refill->getId()));
        }

        return $this->render('FinanceBundle:refill:edit.html.twig', array(
            'refill' => $refill,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a refill entity.
     * @param Request $request
     * @param Refill $refill
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Refill $refill)
    {
        $form = $this->createDeleteForm($refill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($refill);
            $em->flush();
        }

        return $this->redirectToRoute('refill_index');
    }

    /**
     * Creates a form to delete a refill entity.
     *
     * @param Refill $refill The refill entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Refill $refill)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('refill_delete', array('id' => $refill->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
