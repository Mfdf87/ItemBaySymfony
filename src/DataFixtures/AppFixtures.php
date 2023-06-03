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
        // Liste des items à créer
        $listeItems[] = [
            'nom' => 'Potion de soin',
            'stat' => 'PV',
            'description' => 'Restaure 50 PV'
        ];

        $listeItems[] = [
            'nom' => 'Potion de mana',
            'stat' => 'Mana',
            'description' => 'Restaure 50 points de mana'
        ];
        
        $listeItems[] = [
            'nom' => 'Épée en acier',
            'stat' => 'Attaque',
            'description' => 'Une épée en acier de qualité'
        ];
        
        $listeItems[] = [
            'nom' => 'Armure de cuir',
            'stat' => 'Défense',
            'description' => 'Une armure légère en cuir'
        ];
        
        $listeItems[] = [
            'nom' => 'Arc long',
            'stat' => 'Attaque',
            'description' => 'Un arc long pour les archers'
        ];

        $listeItems[] = [
            'nom' => 'Bâton de mage',
            'stat' => 'Attaque',
            'description' => 'Un bâton de mage pour les mages'
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en bois',
            'stat' => 'Défense',
            'description' => 'Un bouclier en bois pour les guerriers'
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en acier',
            'stat' => 'Défense',
            'description' => 'Un bouclier en acier pour les guerriers'
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en fer',
            'stat' => 'Défense',
            'description' => 'Un bouclier en fer pour les guerriers'
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en or',
            'stat' => 'Défense',
            'description' => 'Un bouclier en or pour les guerriers'
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en diamant',
            'stat' => 'Défense',
            'description' => 'Un bouclier en diamant pour les guerriers'
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en mithril',
            'stat' => 'Défense',
            'description' => 'Un bouclier en mithril pour les guerriers'
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en adamantium',
            'stat' => 'Défense',
            'description' => 'Un bouclier en adamantium pour les guerriers'
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en obsidienne',
            'stat' => 'Défense',
            'description' => 'Un bouclier en obsidienne pour les guerriers'
        ];

        $listeItems[] = [
            'nom' => 'Casque en cuir',
            'stat' => 'Défense',
            'description' => 'Un casque en cuir pour les guerriers'
        ];

        $listeItems[] = [
            'nom' => 'Casque en acier',
            'stat' => 'Défense',
            'description' => 'Un casque en acier pour les guerriers'
        ];

        $listeItems[] = [
            'nom' => 'Casque en fer',
            'stat' => 'Défense',
            'description' => 'Un casque en fer pour les guerriers'
        ];

        $listeItems[] = [
            'nom' => 'Casque en or',
            'stat' => 'Défense',
            'description' => 'Un casque en or pour les guerriers'
        ];

        $listeItems[] = [
            'nom' => 'Casque en diamant',
            'stat' => 'Défense',
            'description' => 'Un casque en diamant pour les guerriers'
        ];

        $listeItems[] = [
            'nom' => 'Casque en mithril',
            'stat' => 'Défense',
            'description' => 'Un casque en mithril pour les guerriers'
        ];

        foreach ($listeItems as $itemListe) {
            $item = new Item();
            $item->setNom($itemListe['nom']);
            $item->setStat($itemListe['stat']);
            $item->setDescription($itemListe['description']);
            $item->setQte($this->faker->numberBetween(0, 1000));
            $item->setUrl('Defaut.png');
            $date = new \DateTimeImmutable();
            $date = $date->modify('-' . $this->faker->numberBetween(0, 180) . ' day');
            $item->setCreatedAt($date);
            $item->setPrix($this->faker->numberBetween(0, 1000));
            $manager->persist($item);
        }

        $user = new User();
        $user->setEmail("admin.admin@admin.admin");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword('$2y$13$vJcupS8M/Vncq5.z0RoMGuZeBKVcjrsTj1GaUl/ZWM1.VXyGQIoLi');
        $user->setNom("admin");
        $user->setPrenom("admin");
        $user->setMonnaie(1000000000);
        $manager->persist($user);

        $user = new User();
        $user->setEmail("user.user@user.user");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword('$2y$13$gpV8bdCgjdK92q6i3yeleeSE5LgPWvSBwFlst6BBUtPruKYtaJFVC');
        $user->setNom("user");
        $user->setPrenom("user");
        $user->setMonnaie(1000);
        $manager->persist($user);

        // On créé 100 users aléatoires
        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword('$2y$13$gpV8bdCgjdK92q6i3yeleeSE5LgPWvSBwFlst6BBUtPruKYtaJFVC');
            $user->setNom($this->faker->lastName);
            $user->setPrenom($this->faker->firstName);
            $user->setMonnaie($this->faker->numberBetween(0, 1000));
            $manager->persist($user);
        }

        
        $manager->flush();
    }
}
