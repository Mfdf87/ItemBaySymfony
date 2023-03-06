<?php

namespace App\DataFixtures;

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
        for ($i = 0; $i < 100; $i++) {
            $user = new User;
            $generatedVar = $this->faker->word();
            $user -> setName($generatedVar)
                  -> setEmail($generatedVar . '@example.com')
                  -> setPassword('password');
            $manager->persist($user);
        }
        
        $manager->flush();
    }
}
