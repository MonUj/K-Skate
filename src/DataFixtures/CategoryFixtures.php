<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use App\Entity\Category;



class CategoryFixtures extends Fixture 
{

    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

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
            
            $manager->persist($category);
            $this->addReference('category'.$i, $category);
        }

        $manager->flush();
    }








}


?>