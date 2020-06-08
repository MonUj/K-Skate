<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;
use App\Entity\User;


class UserFixtures extends Fixture
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
            $user->setPassword($password); 
            $user->setAddress($faker->streetAddress);
            $user->setCity($faker->city);
            $user->setphoneNumber($faker->serviceNumber);
            $user->addRole("ROLE_USER");
            $user->setAvatar($faker->imageUrl(64, 64));
            $manager->persist($user);
            $this->addReference('user'.$i, $user);
        }

        $manager->flush();
    }

}


?>