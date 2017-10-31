<?php
/**
 * Created by PhpStorm.
 * User: jack
 * Date: 30.10.17
 * Time: 22:14
 */

namespace FinanceBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use FinanceBundle\Entity\Payment;


class Refill
{
    /**
     * @var int
     */
    private $family_wallet_id = 1;

    /**
     * @var EntityManagerInterface
     */
    private $em;


    /**
     * Refill constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @param Payment $payment
     */
    public function familyBalance(Payment $payment)
    {
        $amount = $payment->getAmount();

        $wallet = $this->em->getRepository('FinanceBundle:Wallet')->find($this->family_wallet_id);

        $balance = $wallet->getBalance() + $amount;

        $wallet->setBalance($balance);

        $this->em->persist($wallet);
        $this->em->flush();
    }

    /**
     * @param Payment $payment
     */
    public function userWalletBalance(Payment $payment)
    {
        $amount = $payment->getAmount();
        $wallet_from_id = $payment->getWalletFrom();
        $wallet_to_id = $payment->getWalletTo();


        $wallet_from = $this->em->getRepository('FinanceBundle:Wallet')->find($wallet_from_id);
        $wallet_to = $this->em->getRepository('FinanceBundle:Wallet')->find($wallet_to_id);

        $wallet_from->setBalance($wallet_from->getBalance() + $amount);
        $wallet_to->setBalance($wallet_to->getBalance() + $amount);

        $this->em->flush();
    }
}