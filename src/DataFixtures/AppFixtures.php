<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
       /**
         *
         * @var UserPasswordHasherInterface
         */
        private $encoder;
        public function __construct(UserPasswordHasherInterface $encoder)
        {
            $this->encoder=$encoder;
        }
    public function load(ObjectManager $manager): void
    {
     
        // use the factory to create a Faker\Generator instance
        //ingredients
        $ingredients=[];
        $faker = Factory::create();
        for ($i=0; $i < 50; $i++) { 
           $intgredient = new Ingredient();
           $intgredient->setName($faker->word())
           ->setPrice(mt_rand(0,100));
           $ingredients[]= $intgredient;
           $manager->persist($intgredient);
        }
        for($r=0;$r<25;$r++){
            $recipe=new Recipe();
            $recipe->setName($faker->word())
            ->setTime(mt_rand(1,1400))
            ->setNbPeople(mt_rand(1,50))
            ->setDifficulty(mt_rand(1,5))
            ->setDescription($faker->text(300))
            ->setPrice(mt_rand(1,1000))
            ->setIsFavorite(mt_rand(0,1)==1 ? true:false)
            ;
            for ($k=0; $k < mt_rand(5,15); $k++) { 
                $recipe->addIngredient($ingredients[mt_rand(0,count($ingredients)-1)]);
            }
            $manager->persist($recipe);
            
        }
        for($u=0;$u<10;$u++){
            $user=new User();
            $user->setFullName($faker->name())
            ->setEmail($faker->email())
            ->setPseudo($faker->firstName)
            ->setPassword($this->encoder->hashPassword($user,'password'))
            ->setRoles(["ROLE_USER "]);
            $manager->persist($user);
        }
        $manager->flush();
    }
}