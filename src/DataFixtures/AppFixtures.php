<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\User;
use App\Entity\TypeItem;
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
        $listeTypeItemObjets = [];
        // Création des types d'items
        $listeTypesItems[] = [
            'nom_type_item' => 'Arme',
            'icon' => 'epee.png'
        ];

        $listeTypesItems[] = [
            'nom_type_item' => 'Armure',
            'icon' => 'armure.png'
        ];

        $listeTypesItems[] = [
            'nom_type_item' => 'Potion',
            'icon' => 'potion.png'
        ];

        $listeTypesItems[] = [
            'nom_type_item' => 'Magie',
            'icon' => 'magie.png'
        ];

        foreach ($listeTypesItems as $listeTypeItem) {
            $typeItem = new TypeItem();
            $typeItem->setNomTypeItem($listeTypeItem['nom_type_item']);
            $typeItem->setIcon($listeTypeItem['icon']);
            $manager->persist($typeItem);
            $listeTypeItemObjets[] = $typeItem;
        }
        
        // Liste des items à créer
        $listeItems[] = [
            'nom' => 'Potion de soin',
            'stat' => 'PV',
            'description' => 'Restaure 50 PV',
            'type_item' => $listeTypeItemObjets[2]
        ];

        $listeItems[] = [
            'nom' => 'Potion de mana',
            'stat' => 'Mana',
            'description' => 'Restaure 50 points de mana',
            'type_item' => $listeTypeItemObjets[2]
        ];
        
        $listeItems[] = [
            'nom' => 'Épée en acier',
            'stat' => 'Attaque',
            'description' => 'Une épée en acier de qualité',
            'type_item' => $listeTypeItemObjets[0]
        ];
        
        $listeItems[] = [
            'nom' => 'Armure de cuir',
            'stat' => 'Défense',
            'description' => 'Une armure légère en cuir',
            'type_item' => $listeTypeItemObjets[1]
        ];
        
        $listeItems[] = [
            'nom' => 'Arc long',
            'stat' => 'Attaque',
            'description' => 'Un arc long pour les archers',
            'type_item' => $listeTypeItemObjets[0]
        ];

        $listeItems[] = [
            'nom' => 'Bâton de mage',
            'stat' => 'Attaque',
            'description' => 'Un bâton de mage pour les mages',
            'type_item' => $listeTypeItemObjets[0]
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en bois',
            'stat' => 'Défense',
            'description' => 'Un bouclier en bois pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en acier',
            'stat' => 'Défense',
            'description' => 'Un bouclier en acier pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en fer',
            'stat' => 'Défense',
            'description' => 'Un bouclier en fer pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en or',
            'stat' => 'Défense',
            'description' => 'Un bouclier en or pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en diamant',
            'stat' => 'Défense',
            'description' => 'Un bouclier en diamant pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en mithril',
            'stat' => 'Défense',
            'description' => 'Un bouclier en mithril pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en adamantium',
            'stat' => 'Défense',
            'description' => 'Un bouclier en adamantium pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Bouclier en obsidienne',
            'stat' => 'Défense',
            'description' => 'Un bouclier en obsidienne pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Casque en cuir',
            'stat' => 'Défense',
            'description' => 'Un casque en cuir pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Casque en acier',
            'stat' => 'Défense',
            'description' => 'Un casque en acier pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Casque en fer',
            'stat' => 'Défense',
            'description' => 'Un casque en fer pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Casque en or',
            'stat' => 'Défense',
            'description' => 'Un casque en or pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Casque en diamant',
            'stat' => 'Défense',
            'description' => 'Un casque en diamant pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Casque en mithril',
            'stat' => 'Défense',
            'description' => 'Un casque en mithril pour les guerriers',
            'type_item' => $listeTypeItemObjets[1]
        ];

        $listeItems[] = [
            'nom' => 'Boule de feu',
            'stat' => 'Attaque',
            'description' => 'Une boule de feu',
            'type_item' => $listeTypeItemObjets[3]
        ];

        $listeItems[] = [
            'nom' => 'Boule de glace',
            'stat' => 'Attaque',
            'description' => 'Une boule de glace',
            'type_item' => $listeTypeItemObjets[3]
        ];

        $listeItems[] = [
            'nom' => 'Boule de foudre',
            'stat' => 'Attaque',
            'description' => 'Une boule de foudre',
            'type_item' => $listeTypeItemObjets[3]
        ];

        $listeItems[] = [
            'nom' => 'Boule de poison',
            'stat' => 'Attaque',
            'description' => 'Une boule de poison',
            'type_item' => $listeTypeItemObjets[3]
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
            // Si jamais l'item contient un type, on le lie à l'item
            if ($itemListe['type_item'] != null) {
                $item->setTypeItem($itemListe['type_item']);
            }
            $manager->persist($item);
        }

        $user = new User();
        $user->setEmail("admin.admin@admin.admin");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword('$2y$13$vJcupS8M/Vncq5.z0RoMGuZeBKVcjrsTj1GaUl/ZWM1.VXyGQIoLi');
        $user->setNom("admin");
        $user->setPrenom("admin");
        $user->setMonnaie(1000000000);
        $user->setQuete(0);
        $manager->persist($user);

        $user = new User();
        $user->setEmail("user.user@user.user");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword('$2y$13$gpV8bdCgjdK92q6i3yeleeSE5LgPWvSBwFlst6BBUtPruKYtaJFVC');
        $user->setNom("user");
        $user->setPrenom("user");
        $user->setMonnaie(1000);
        $user->setQuete(0);
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
            $user->setQuete(0);
            $manager->persist($user);
        }

        
        $manager->flush();
    }
}
