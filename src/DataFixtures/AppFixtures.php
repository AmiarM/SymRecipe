<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // use the factory to create a Faker\Generator instance
        $faker = Factory::create();
        for ($i=0; $i < 50; $i++) { 
           $intgredient = new Ingredient();
           $intgredient->setName($faker->word())
           ->setPrice(mt_rand(0,100));
           $manager->persist($intgredient);
        }
        $manager->flush();
    }
}