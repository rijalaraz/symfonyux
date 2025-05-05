<?php

namespace App\DataFixtures;

use App\Entity\Situation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SituationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $aSituations = [
            'Célibataire',
            'Marié',
            'Séparé',
            'Divorcé',
            'Compliqué',
        ];

        foreach ($aSituations as $situation) {
            $situ = new Situation();
            $situ->setName($situation);
            $manager->persist($situ);
        }

        $manager->flush();
    }
}
