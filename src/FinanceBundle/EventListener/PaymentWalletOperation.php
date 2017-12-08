<?php
/**
 * Created by PhpStorm.
 * User: jack
 * Date: 07.12.17
 * Time: 21:20
 */

namespace FinanceBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\OptimisticLockException;
use FinanceBundle\Entity\Payment;
use FinanceBundle\Entity\Wallet;

class PaymentWalletOperation
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $payment = $args->getEntity();

        if (!$payment instanceof Payment) {
            return;
        }

        $em = $args->getEntityManager();

        $amount = $payment->getAmount();

        $walletFrom = $em->getRepository(Wallet::class)->find($payment->getWalletFrom());

        if ($walletFrom) {
            $balance = $walletFrom->getBalance() - $amount;

            $walletFrom->setBalance($balance);

            $em->persist($walletFrom);
            try {
                $em->flush();
            } catch (OptimisticLockException $e) {
            }
        }
    }
}
