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

        $user = new User();
        $user->setEmail("admin.admin@admin.admin");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword('$2y$13$vJcupS8M/Vncq5.z0RoMGuZeBKVcjrsTj1GaUl/ZWM1.VXyGQIoLi');
        $user->setNom("admin");
        $user->setPrenom("admin");
        $user->setMonnaie(1000);
        $manager->persist($user);

        $user = new User();
        $user->setEmail("user.user@user.user");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword('$2y$13$gpV8bdCgjdK92q6i3yeleeSE5LgPWvSBwFlst6BBUtPruKYtaJFVC');
        $user->setNom("user");
        $user->setPrenom("user");
        $user->setMonnaie(1000);
        $manager->persist($user);

        
        $manager->flush();
    }
}
