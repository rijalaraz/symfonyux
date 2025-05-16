<?php

namespace App\DataFixtures;

use App\Entity\Meal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MealFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $aMeals = [
            'Breakfast',
            'Second Breakfast',
            'Dessert',
            'Lunch',
            'Dinner'
        ];

        foreach ($aMeals as $mealName) {
            $meal = new Meal();
            $meal->setName($mealName);
            $manager->persist($meal);   
        }

        $manager->flush();
    }
}
