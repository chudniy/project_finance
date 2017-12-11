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
    private $familyWalletId = 1;

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

        $wallet = $this->em->getRepository('FinanceBundle:Wallet')->find($this->familyWalletId);

        if ($wallet) {
            $balance = $wallet->getBalance() + $amount;

            $wallet->setBalance($balance);

            $this->em->persist($wallet);
            $this->em->flush();
        }
    }

    /**
     * @param Payment $payment
     */
    public function userWalletBalance(Payment $payment)
    {
        $amount = $payment->getAmount();
        $walletFromId = $payment->getWalletFrom();
        $walletToId = $payment->getWalletTo();


        $walletFrom = $this->em->getRepository('FinanceBundle:Wallet')->find($walletFromId);
        $walletTo = $this->em->getRepository('FinanceBundle:Wallet')->find($walletToId);

        if ($walletFrom && $walletTo) {
            $walletFrom->setBalance($walletFrom->getBalance() - $amount);
            $walletTo->setBalance($walletTo->getBalance() + $amount);

            $this->em->flush();
        }
    }
}
