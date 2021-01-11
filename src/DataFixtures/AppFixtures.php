<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $formation1 = new Formation();
        $formation1->setIntitule("Formation1");
        $formation1->setNiveau("2° année");
        $formation1->setVille("Anglet");
        $manager->persist($formation1);

        $manager->flush();
    }
}
