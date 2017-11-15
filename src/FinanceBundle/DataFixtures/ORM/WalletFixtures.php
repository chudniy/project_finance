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
use FinanceBundle\Entity\Wallet;

class WalletFixtures extends Fixture
{
    /**
     * @var array
     */
    private $wallets = array(
        'wallet_1',
        'wallet_2',
    );

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->wallets as $key => $wallet) {
            $entity = new Wallet();
            $entity->setName($wallet);
            $entity->setUser($this->getReference('user_' . $key));
            $manager->persist($entity);

            $this->addReference('wallet_'. $key, $entity);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
