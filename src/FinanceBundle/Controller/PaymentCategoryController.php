<?php

namespace FinanceBundle\Controller;

use FinanceBundle\Entity\PaymentCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Paymentcategory controller.
 *
 */
class PaymentCategoryController extends Controller
{
    /**
     * Lists all paymentCategory entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paymentCategories = $em->getRepository('FinanceBundle:PaymentCategory')->findAll();

        return $this->render('FinanceBundle:paymentcategory:index.html.twig', array(
            'paymentCategories' => $paymentCategories,
        ));
    }

    /**
     * Creates a new paymentCategory entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $paymentCategory = new Paymentcategory();
        $form = $this->createForm('FinanceBundle\Form\PaymentCategoryType', $paymentCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paymentCategory);
            $em->flush();

            return $this->redirectToRoute('payment_category_show', array('id' => $paymentCategory->getId()));
        }

        return $this->render('FinanceBundle:paymentcategory:new.html.twig', array(
            'paymentCategory' => $paymentCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a paymentCategory entity.
     * @param PaymentCategory $paymentCategory
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(PaymentCategory $paymentCategory)
    {
        $deleteForm = $this->createDeleteForm($paymentCategory);

        return $this->render('FinanceBundle:paymentcategory:show.html.twig', array(
            'paymentCategory' => $paymentCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing paymentCategory entity.
     * @param Request $request
     * @param PaymentCategory $paymentCategory
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, PaymentCategory $paymentCategory)
    {
        $deleteForm = $this->createDeleteForm($paymentCategory);
        $editForm = $this->createForm('FinanceBundle\Form\PaymentCategoryType', $paymentCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payment_category_edit', array('id' => $paymentCategory->getId()));
        }

        return $this->render('FinanceBundle:paymentcategory:edit.html.twig', array(
            'paymentCategory' => $paymentCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a paymentCategory entity.
     * @param Request $request
     * @param PaymentCategory $paymentCategory
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, PaymentCategory $paymentCategory)
    {
        $form = $this->createDeleteForm($paymentCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($paymentCategory);
            $em->flush();
        }

        return $this->redirectToRoute('payment_category_index');
    }

    /**
     * Creates a form to delete a paymentCategory entity.
     *
     * @param PaymentCategory $paymentCategory The paymentCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PaymentCategory $paymentCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('payment_category_delete', array('id' => $paymentCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
