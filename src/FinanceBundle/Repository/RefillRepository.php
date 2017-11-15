<?php

namespace FinanceBundle\Repository;

use FinanceBundle\Entity\Refill;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

/**
 * RefillRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RefillRepository extends EntityRepository
{
    /**
     * @param Request $request
     * @return Refill[]
     */
    public function refillByRequest(Request $request)
    {
        $qb = $this->createQueryBuilder('payment');

        if ($wallet_from = $request->get('wallet_from')) {
            $qb->leftJoin('payment.walletFrom', 'walletFrom')
                ->andWhere('walletFrom.name = :wallet_from')
                ->setParameter(':wallet_from', $wallet_from);
        }

        if ($wallet_to = $request->get('wallet_to')) {
            $qb->leftJoin('payment.walletTo', 'walletTo')
                ->andWhere('walletTo.name = :wallet_to')
                ->setParameter(':wallet_to', $wallet_to);
        }

        if ($amount = $request->get('amount')) {
            $qb->andWhere('payment.amount = :amount')
                ->setParameter(':amount', $amount);
        }

        if ($description = $request->get('description')) {
            $qb->andWhere($qb->expr()->like('payment.description', ':description'))
                ->setParameter(':description', '%' . $description . '%');
        }

        if ($date = $request->get('date')) {
            $qb->andWhere('payment.date = :date')
                ->setParameter(':date', date('Y-m-d', strtotime($date)));
        }


        return $qb->getQuery()->getResult();
    }
}