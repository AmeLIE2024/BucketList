<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $category1 = new Category();
        $category1->setName('A faire dans sa vie');
        $category1->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($category1);
        $this->addReference('category1',$category1);

        $category2 = new Category();
        $category2->setName('Pas obligatoire mais ça serait cool');
        $category2->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($category2);
        $this->addReference('category2', $category2);

        $manager->flush();
    }
}
