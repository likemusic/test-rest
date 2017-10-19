<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $userManager)
    {
        for ($i = 0; $i < 5; $i++) {
            $product = new Category();
            $product->setName('Category ' . ($i + 1));
            $userManager->persist($product);
            $this->addReference('category' . $i , $product);
        }

        $userManager->flush();
    }
}