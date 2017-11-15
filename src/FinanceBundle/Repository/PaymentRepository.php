<?php

namespace FinanceBundle\Repository;

use FinanceBundle\Entity\Payment;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

/**
 * PaymentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PaymentRepository extends EntityRepository
{
    /**
     * @param Request $request
     * @return Payment[]
     */
    public function paymentByRequest(Request $request)
    {
        $qb = $this->createQueryBuilder('payment');

        if ($category = $request->get('category')) {
            $qb->leftJoin('payment.category', 'category')
                ->andWhere('category.name = :category')
                ->setParameter(':category', $category);
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