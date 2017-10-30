<?php
/**
 * Created by PhpStorm.
 * User: jack
 * Date: 30.10.17
 * Time: 22:14
 */

namespace FinanceBundle\Model;

use Doctrine\ORM\EntityManagerInterface;
use FinanceBundle\Entity\Payment;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Refill extends Controller
{
    /**
     * @var int
     */
    private $family_wallet_id = 1;

    /**
     * @param Payment $payment
     */
    public function familyBalance(Payment $payment)
    {
        $amount = $payment->getAmount();

        $em = $this->getDoctrine()->getManager();
        $wallet = $em->getRepository('FinanceBundle:Wallet')->find($this->family_wallet_id);

        $balance = $wallet->getBalance() + $amount;

        $wallet->setBalance($balance);

        $em->persist($wallet);
        $em->flush();
    }

    /**
     * @param Payment $payment
     */
    public function userWalletBalance(Payment $payment)
    {
        $amount = $payment->getAmount();
        $wallet_from_id = $payment->getWalletFrom();
        $wallet_to_id = $payment->getWalletTo();

        $em = $this->getDoctrine()->getManager();

        $wallet_from = $em->getRepository('FinanceBundle:Wallet')->find($wallet_from_id);
        $wallet_to = $em->getRepository('FinanceBundle:Wallet')->find($wallet_to_id);

        $wallet_from->setBalance($wallet_from->getBalance() + $amount);
        $wallet_to->setBalance($wallet_to->getBalance() + $amount);

        $em->flush();
    }
}