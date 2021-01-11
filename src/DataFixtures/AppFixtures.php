<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Creation d'un générateur de données Faker
        $faker = \Faker\Factory::create('fr_FR');

        $nbFormations = 10;

        for ($i=1; $i < $nbFormations; $i++) {
          //Creation d'une nouvelle formation
          $formation1 = new Formation();
          //Génération d'un nom de formation avec un numéro compris entre 0 99
          $formation1->setIntitule($faker->regexify('Formation [0-9][1-9]'));
          //Génération d'un niveau qui est soit 1° ou 2° année
          $formation1->setNiveau($faker->regexify('[1-2]° année'));
          //Génération d'une ville
          $formation1->setVille($faker->city());
          //Enregistrement du module créé
          $manager->persist($formation1);
        }


        $manager->flush();
    }
}
