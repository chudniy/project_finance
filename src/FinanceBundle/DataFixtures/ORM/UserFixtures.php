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
use FinanceBundle\Entity\User;

class UserFixtures extends Fixture
{
    private $users = array(
        'Jack',
        'Tania',
    );

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->users as $key => $user) {
            $entity = new User();
            $entity->setName($user);
            $manager->persist($entity);

            $this->addReference('user_'. $key, $entity);
        }

        $manager->flush();
    }
}
