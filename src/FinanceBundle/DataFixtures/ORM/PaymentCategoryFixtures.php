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

class PaymentCategoryFixtures extends Fixture
{
    private $categories = array(
        'category_1',
        'category_2',
    );

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->categories as $key => $category) {
            $entity = new PaymentCategory();
            $entity->setName($category);
            $manager->persist($entity);

            $this->addReference('category_'. $key, $entity);
        }

        $manager->flush();
    }
}
