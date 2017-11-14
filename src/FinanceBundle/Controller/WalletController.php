<?php

namespace FinanceBundle\Controller;

use FinanceBundle\Entity\Wallet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Контроллер кошельков.
 *
 */
class WalletController extends Controller
{
    /**
     * Lists all wallet entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $wallets = $em->getRepository('FinanceBundle:Wallet')->findAll();

        return $this->render('FinanceBundle:wallet:index.html.twig', array(
            'wallets' => $wallets,
        ));
    }

    /**
     * Creates a new wallet entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $wallet = new Wallet();
        $form = $this->createForm('FinanceBundle\Form\WalletType', $wallet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wallet);
            $em->flush();

            return $this->redirectToRoute('wallet_show', array('id' => $wallet->getId()));
        }

        return $this->render('FinanceBundle:wallet:new.html.twig', array(
            'wallet' => $wallet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a wallet entity.
     *
     * @param Wallet $wallet
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Wallet $wallet)
    {
        $deleteForm = $this->createDeleteForm($wallet);

        return $this->render('FinanceBundle:wallet:show.html.twig', array(
            'wallet' => $wallet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing wallet entity.
     *
     * @param Request $request
     * @param Wallet $wallet
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Wallet $wallet)
    {
        $deleteForm = $this->createDeleteForm($wallet);
        $editForm = $this->createForm('FinanceBundle\Form\WalletType', $wallet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wallet_edit', array('id' => $wallet->getId()));
        }

        return $this->render('FinanceBundle:wallet:edit.html.twig', array(
            'wallet' => $wallet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a wallet entity.
     *
     * @param Request $request
     * @param Wallet $wallet
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Wallet $wallet)
    {
        $form = $this->createDeleteForm($wallet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($wallet);
            $em->flush();
        }

        return $this->redirectToRoute('wallet_index');
    }

    /**
     * Creates a form to delete a wallet entity.
     *
     * @param Wallet $wallet The wallet entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Wallet $wallet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('wallet_delete', array('id' => $wallet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
