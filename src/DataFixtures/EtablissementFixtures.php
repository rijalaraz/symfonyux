<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EtablissementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0 ; $i < 5 ; $i++ ) { 
            $etablissement = new Etablissement();
            $etablissement->setNomEtablissement($faker->name());
            $etablissement->setNombrePlace(rand(200, 1000));
            $etablissement->setDescription($faker->paragraph());
            $min = 100.00;
            $max = 1000.00;
            $randomTarifMin = number_format(mt_rand($min * 100, $max * 100) / 100, 2);
            $etablissement->setTarifMin(strval($randomTarifMin));
            $min = 1000.00;
            $max = 10000.00;
            $randomTarifMax = number_format(mt_rand($min * 100, $max * 100) / 100, 2);
            $etablissement->setTarifMax(strval($randomTarifMax));

            $manager->persist($etablissement);
        }

        $manager->flush();
    }
}
