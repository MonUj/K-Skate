<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use App\Entity\Commande;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\UserFixtures;



class CommandeFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        //création de 10 commandes
        for($i = 0; $i < 10; $i++)
        {
           
            $userFake = rand(0,9);
            

            $commande = new Commande();
            $commande->setReference($faker->unique()->randomNumber(8, false));
            $commande->setNbPro($faker->numberBetween(1,15));
            $commande->setMontant($faker->randomFloat(4, 0, 100));
            $commande->setDate($faker->dateTime);
            $commande->setStatut($faker->boolean);
            $commande->setUser($this->getReference('user'.$userFake));
            $manager->persist($commande);
            $this->addReference('commande'.$i, $commande);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}


?>