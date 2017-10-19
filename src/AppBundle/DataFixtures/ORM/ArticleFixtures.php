<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $userManager)
    {
        for ($i = 0; $i < 5; $i++) {
            $entity = new Article();
            $entity
                ->setTitle('Title ' . ($i + 1))
                ->setContent('Content ' . ($i + 1))
            ;

            $entity->setCategory($this->getReference('category' . $i));
            $userManager->persist($entity);
        }

        $userManager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}