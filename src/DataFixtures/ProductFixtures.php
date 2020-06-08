<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use App\Entity\Product;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CategoryFixtures;


class ProductFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        //création de 10 produits
        for($i = 0; $i < 10; $i++)
        {
            
            $userFake = rand(0,9);
            $commandeFake = rand(0,9);
            $categoryFake = rand(0,4);
            
            $product = new Product();
            $product->setLabel($faker->jobTitle); // à modifier pour afficher le nom d'un produit
            $product->setPrix($faker->randomFloat(4, 0, 20));
            $product->setFilename($faker->imageUrl(200, 200));
            $product->setMarque($faker->company); //à modifier pour mettre le nom d'une marque
            $product->setDescription($faker->text(100));
            $product->setCommande($this->getReference('commande'.$commandeFake));
            $product->setCategory($this->getReference('category'.$categoryFake));
            $product->setUserProprio($this->getReference('user'.$userFake)); 
            //$product->setUserAcheteur($userFakeRepository);
            $product->setDatecreated($faker->dateTime);
            $product->setDateupdated($faker->dateTime);
            $manager->persist($product);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            CategoryFixtures::class,
        );
    }
}

?>