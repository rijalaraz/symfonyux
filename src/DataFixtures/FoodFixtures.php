<?php

namespace App\DataFixtures;

use App\Entity\Food;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FoodFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $aFoods = [
            'Banana 🍌',
            'Apple 🍎',
            'Hamburger 🍔',
            'Watermelon 🍉',
            'Cheese 🧀',
            'Pizza 🍕',
            'Pretzel 🥨',
            'Donut 🍩',
            'Pineapple 🍍',
            'Popcorn 🍿',
            'Egg 🍳',
            'Taco 🌮',
            'Ice Cream 🍦',
            'Cookie 🍪'
        ];

        foreach ($aFoods as $strFood) {
            $food = new Food();
            $food->setName($strFood);
            $manager->persist($food);
        }

        $manager->flush();
    }
}
