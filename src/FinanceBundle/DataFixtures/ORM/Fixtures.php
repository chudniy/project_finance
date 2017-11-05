<?php
/**
 * Created by PhpStorm.
 * User: jack
 * Date: 05.11.17
 * Time: 21:42
 */

namespace FinanceBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use FinanceBundle\Entity\PaymentCategory;
use FinanceBundle\Entity\User;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 3 users!
        for ($i = 0; $i < 4; $i++) {
            $user = new User();
            $user->setName('user'.$i);
        }

        // create 3 payment_categories!
        for ($i = 0; $i < 4; $i++) {
            $category = new PaymentCategory();
            $category->setName('category'.$i);
        }

        $manager->flush();
    }
}