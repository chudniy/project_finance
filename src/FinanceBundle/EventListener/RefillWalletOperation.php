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
use FinanceBundle\Entity\Refill;
use FinanceBundle\Entity\Wallet;
use Symfony\Component\Config\Definition\Exception\Exception;

class RefillWalletOperation
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $refill = $args->getEntity();

        if (!$refill instanceof Refill) {
            return;
        }

        $em = $args->getEntityManager();

        $amount = $refill->getAmount();

        $walletFrom = $em->getRepository(Wallet::class)->find($refill->getWalletFrom());
        $walletTo = $em->getRepository(Wallet::class)->find($refill->getWalletTo());

        if ($walletFrom && $walletTo) {
            $balanceFrom = $walletFrom->getBalance() - $amount;
            $balanceTo = $walletTo->getBalance() + $amount;

            if ($balanceFrom < 0) {
                throw new Exception('Not enough money for refill');
            }

            $walletFrom->setBalance($balanceFrom);
            $walletTo->setBalance($balanceTo);

            $em->persist($walletFrom);
            $em->persist($walletTo);
            try {
                $em->flush();
            } catch (OptimisticLockException $e) {
            }
        }
    }
}
