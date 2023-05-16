<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Compte;
use App\Entity\Item;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }


    public function load(ObjectManager $manager): void
    {
        // On créé 100 items aléatoires
        for ($i = 0; $i < 15; $i++) {
            $item = new Item();
            $item->setNom($this->faker->words(3, true));
            $item->setStat($this->faker->words(3, true));
            $item->setDescription($this->faker->words(3, true));
            $item->setQte($this->faker->words(3, true));
            $item->setUrl($this->faker->imageUrl(640, 480, 'item', true, true));
            $date = new \DateTimeImmutable();
            $date = $date->modify('-' . $this->faker->numberBetween(0, 180) . ' day');
            $item->setCreatedAt($date);
            $manager->persist($item);
        }

        $compte = new Compte();
        // On créé le compte admin admin
        $compte->setNom('admin');
        $compte->setPrenom('admin');
        $compte->setMonnaie(1000);
        $compte->setIsAdmin(true);
        $compte->setPassword('admin');
        $compte->setEmail('admin.admin@admin.admin');
        $manager->persist($compte);

        // On créé le compte user user
        $compte = new Compte();
        $compte->setNom('user');
        $compte->setPrenom('user');
        $compte->setMonnaie(1000);
        $compte->setIsAdmin(false);
        $compte->setPassword('user');
        $compte->setEmail('user.user@user.user');
        $manager->persist($compte);
        
        $manager->flush();
    }
}
