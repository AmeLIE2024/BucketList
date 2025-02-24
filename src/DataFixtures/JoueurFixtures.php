<?php

namespace App\DataFixtures;

use App\Entity\Joueur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
class JoueurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 20; $i ++) {
            $joueur = new Joueur();
            $joueur->setFirstname($faker->firstName());
            $joueur->setLastname($faker->lastName());
            $joueur->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($joueur);
            $this->addReference('joueur'.$i, $joueur);
        }
        $manager->flush();
    }
}
