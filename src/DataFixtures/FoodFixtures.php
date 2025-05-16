<?php

namespace App\DataFixtures;

use App\Entity\Food;
use App\Entity\Meal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FoodFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $meals = $manager->getRepository(Meal::class)->findAll();

        $aFoods = [
            [
                'food' => 'Banana 🍌',
                'meal' => $meals[2]
            ],
            [
                'food' => 'Apple 🍎',
                'meal' => $meals[2]
            ],
            [
                'food' => 'Hamburger 🍔',
                'meal' => $meals[3]
            ],
            [
                'food' => 'Watermelon 🍉',
                'meal' => $meals[2]
            ],
            [
                'food' => 'Cheese 🧀',
                'meal' => $meals[3]
            ],
            [
                'food' => 'Pizza 🍕',
                'meal' => $meals[4]
            ],
            [
                'food' => 'Pretzel 🥨',
                'meal' => $meals[2]
            ],
            [
                'food' => 'Donut 🍩',
                'meal' => $meals[0]
            ],
            [
                'food' => 'Pineapple 🍍',
                'meal' => $meals[2]
            ],
            [
                'food' => 'Popcorn 🍿',
                'meal' => $meals[1]
            ],
            [
                'food' => 'Egg 🍳',
                'meal' => $meals[0]
            ],
            [
                'food' => 'Taco 🌮',
                'meal' => $meals[4]
            ],
            [
                'food' => 'Ice Cream 🍦',
                'meal' => $meals[2]
            ],
            [
                'food' => 'Cookie 🍪',
                'meal' => $meals[2]
            ],
            [
                'food' => 'Strawberries 🍓',
                'meal' => $meals[2],
            ],
            [
                'food' => 'Croissant 🥐',
                'meal' => $meals[0]
            ],
            [
                'food' => 'Sushi 🍱',
                'meal' => $meals[3]
            ],
            [
                'food' => 'Tea ☕️',
                'meal' => $meals[2]
            ],
            [
                'food' => 'Kiwi 🥝',
                'meal' => $meals[1]
            ],
            [
                'food' => 'A Pint 🍺',
                'meal' => $meals[4]
            ],
            [
                'food' => 'Bagel 🥯',
                'meal' => $meals[1]
            ],
            [
                'food' => 'Bacon 🥓',
                'meal' => $meals[0]
            ],
            [
                'food' => 'Waffles 🧇',
                'meal' => $meals[1]
            ],
            [
                'food' => 'Sandwich 🥪',
                'meal' => $meals[3]
            ],
            [
                'food' => 'Avocado 🥑',
                'meal' => $meals[1]
            ],
            [
                'food' => 'Pasta 🍝',
                'meal' => $meals[4]
            ],
            [
                'food' => 'Pancakes 🥞',
                'meal' => $meals[0]
            ]
        ];

        foreach ($aFoods as $aFood) {
            $food = new Food();
            $food->setName($aFood['food']);
            $food->setMeal($aFood['meal']);
            $manager->persist($food);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MealFixtures::class
        ];
    }
}
