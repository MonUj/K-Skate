<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Commande;
use App\Entity\Category;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');
        
        //création de 10 Users
        for($i = 0; $i < 10; $i++)
        {
            $user = new User();
            $user->setName($faker->lastname);
            $user->setfirstName($faker->firstname);
            $user->setEmail($faker->email);
            $password = $this->encoder->encodePassword($user, 'Pass1234@');
            $user->setPassword($password); //$faker->password
            $user->setAddress($faker->streetAddress);
            $user->setCity($faker->city);
            $user->setphoneNumber($faker->serviceNumber);
            $user->addRole("ROLE_USER");
            $user->setAvatar($faker->image('public/images/avatar', 64, 64));
            $manager->persist($user);
        }

        //création 5 catégories
        for($i = 0; $i <5; $i++)
        {
            $category = new Category();
            if ($i == 0)
            {
                $category->setLabel('Casquette');
            }
            else
            {
                if ($i == 1)
                {
                    $category->setLabel('Chapeau');
                }
                else
                {
                    if ($i == 2)
                    {
                        $category->setLabel('Bonnet');
                    }
                    else
                    {
                        if ($i == 3)
                        {
                            $category->setLabel('Béret');
                        }
                        else
                        {
                            if($i == 4)
                            {
                                $category->setLabel('Bob');
                            }
                        }
                    }
                }
            }
            // ne pas oublier méthode addproduct()
            $manager->persist($category);
        }

        //création de 10 commandes
        for($i = 0; $i < 10; $i++)
        {
            // $user fake repository

            $commande = new Commande();
            $commande->setReference($faker->unique()->randomNumber(8, false));
            $commande->setNbPro($faker->numberBetween(1,15));
            $commande->setMontant($faker->randomFloat(4, 0, 100));
            $commande->setDate($faker->dateTime);
            $commande->setStatut($faker->boolean);
            //$commande->setUser();
            $manager->persist($commande);
        }

        //création de 10 produits
        for($i = 0; $i < 10; $i++)
        {
            // category fake
            
            $product = new Product();
            $product->setLabel($faker->word); // à modifier pour afficher le nom d'un produit
            $product->setPrix($faker->randomFloat(4, 0, 20));
            $product->setImage($faker->image('public/images/avatar', 200, 200));
            $product->setMarque($faker->word); //à modifier pour mettre le nom d'une marque
            $product->setDescription($faker->text(100));
            //$product->setCategory();
            $manager->persist($product);
        }




        

        $manager->flush();
    }
}
