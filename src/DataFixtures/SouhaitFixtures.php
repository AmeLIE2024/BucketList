<?php

namespace App\DataFixtures;

use App\DataFixtures\CategoryFixtures;
use App\DataFixtures\JoueurFixtures;
use App\Entity\Joueur;
use App\Entity\Category;
use App\Entity\Souhait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SouhaitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $souhait = new Souhait();
        $souhait->setName('Chats');
        $souhait->setContent('Je voudrais avoir une brassée de chatons trop mignons !');
        $souhait->setCreatedAt(new \DateTimeImmutable('2025-01-01'));
        $souhait->setIsPublished(true);

        $souhait->setCategory($this->getReference('category2', Category::class));
        $this->getJoueurs($souhait);
        $manager->persist($souhait);

        $souhait = new Souhait();
        $souhait->setName('Voyages');
        $souhait->setContent('Je voudrais voyager en asie et découvrir le monde !');
        $souhait->setCreatedAt(new \DateTimeImmutable('2025-02-23'));
        $souhait->setIsPublished(true);
        $souhait->setCategory($this->getReference('category1', Category::class));
        $this->getJoueurs($souhait);
        $manager->persist($souhait);

        $souhait = new Souhait();
        $souhait->setName('Travail');
        $souhait->setContent('Je voudrais faire un travail qui me plait pour ne pas m\' ennuyer !');
        $souhait->setCreatedAt(new \DateTimeImmutable('2025-02-23'));
        $souhait->setIsPublished(true);
        $souhait->setCategory($this->getReference('category2', Category::class));
        $this->getJoueurs($souhait);
        $manager->persist($souhait);

        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 30; $i++) {
            $souhait = new Souhait();
            $souhait->setName($faker->word());
            $souhait->setContent($faker->realText());
            $CreatedAt = $faker->DateTimeBetween('-2 months', 'now');
            $souhait->setCreatedAt(\DateTimeImmutable::createFromMutable($CreatedAt));
            $souhait->setIsPublished(false);
            $souhait->setCategory($this->getReference('category' . mt_rand(1, 2), Category::class));
            $this->getJoueurs($souhait);
            $manager->persist($souhait);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class, JoueurFixtures::class];
    }


    private function getJoueurs(Souhait $souhait): void
    {
        for ($i = 0; $i <= mt_rand(0, 5); $i++) {
            $joueur = $this->getReference('joueur' .mt_rand(1, 20), Joueur::class);
            $souhait->addJoueur($joueur);
        }
    }
}