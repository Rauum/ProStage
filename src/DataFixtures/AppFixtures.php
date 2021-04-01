<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Creation de 2 utilisateurs de test
        $romain = new User();
        $romain->setPrenom("Romain");
        $romain->setNom("Vaché");
        $romain->setEmail("vache.romain30@gmail.com");
        $romain->setRoles(["ROLE_USER","ROLE_ADMIN"]);
        $romain->setPassword('$2y$10$.ZPzVMcmE/iMXGcG/GqoseVlv5AttrktVBSNPTI4rwhmnxeQhLBEq');
        $manager->persist($romain);

        $test = new User();
        $test->setPrenom("Test");
        $test->setNom("Testeur");
        $test->setEmail("test@gmail.com");
        $test->setRoles(["ROLE_USER"]);
        $test->setPassword('$2y$10$FXWM5/5Nf7TCTi6Z3N4Xl.BgRKu8gKvbJ3HiaU./r9rB6N9ex6ndi');
        $manager->persist($test);



        //Creation d'un générateur de données Faker
        $faker = \Faker\Factory::create('fr_FR');

        /***************************************
        *** CREATION DES DIFFENTES ENTREPRISES ***
        ****************************************/
        //Création de UstaInfo
        $UstaInfo = new Entreprise();
        $UstaInfo-> setNom("UstaInfo");
        $UstaInfo-> setAdresse($faker->address());
        $UstaInfo-> setDommaineActivite("Informatique");
        $UstaInfo-> setNumTel($faker->regexify("0[1-9]{9}"));
        $UstaInfo-> setSitWeb("UstaInfo.fr");

        //Création de ICCInformatique
        $ICCInformatique = new Entreprise();
        $ICCInformatique-> setNom("ICCInformatique");
        $ICCInformatique-> setAdresse($faker->address());
        $ICCInformatique-> setDommaineActivite("Informatique");
        $ICCInformatique-> setNumTel($faker->regexify("0[1-9]{9}"));
        $ICCInformatique-> setSitWeb("ICCInformatique.fr");

        //Création de LogicielMalin
        $LogicielMalin = new Entreprise();
        $LogicielMalin-> setNom("LogicielMalin");
        $LogicielMalin-> setAdresse($faker->address());
        $LogicielMalin-> setDommaineActivite("Informatique");
        $LogicielMalin-> setNumTel($faker->regexify("0[1-9]{9}"));
        $LogicielMalin-> setSitWeb("LogicielMalin.fr");

        //Création de TecInfo
        $TecInfo = new Entreprise();
        $TecInfo-> setNom("TecInfo");
        $TecInfo-> setAdresse($faker->address());
        $TecInfo-> setDommaineActivite("Informatique");
        $TecInfo-> setNumTel($faker->regexify("0[1-9]{9}"));
        $TecInfo-> setSitWeb("TecInfo.fr");

        /* On regroupe les objets "Entreprises" dans un tableau
        pour pouvoir s'y référer au moment de la création d'un stage particulier */
        $tableauEntreprises = array($UstaInfo,$ICCInformatique,$LogicielMalin,$TecInfo);

        // Mise en persistance des objets entreprise
      foreach ($tableauEntreprises as $entreprise) {
          $manager->persist($entreprise);
      }

      /***************************************
            ***  LISTE DES FORMATIONS  ***
       ****************************************/
          $formations = array(
            "Testeur" => "2° Année",
            "Programmeur Symphony" => "2° Année",
            "Concepteur" => "1° Année",
            "Programmeur C++" => "1° Année",
            "Programmeur Assembleur" => "1° Année",
            "Programmeur Web" => "2° Année"
            );

      /********************************************************
       **** CREATION DES FORMATIONS ET STAGES ASSOCIEES  *****
      *********************************************************/
      foreach ($formations as $intituleFormation => $niveauFormation) {
            // ************* Création d'un nouveau module *************
            $formations = new Formation();
            // Définition du nom de formation
            $formations->setIntitule($intituleFormation);
            // Définition du niveau de la formation
            $formations->setNiveau($niveauFormation);
            // Définition de la ville de la formation
            $formations->setVille($faker->city());
            // Enregistrement de la formation créé
            $manager->persist($formations);

      // **** Création de plusieurs stages associées aux formations
      $nbStagesAGenerer = $faker->numberBetween($min = 0, $max = 3);
      for ($numStage=0; $numStage < $nbStagesAGenerer; $numStage++) {
            $stage = new Stage();
            $stage -> setIntitule("Stage en tant que : $intituleFormation ");
            $stage -> setDescription("Pour le moment, ce stage n'a pas de description");
            $stage -> setDateDebut($faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = 'Europe/Paris'));
            $stage -> setDuree($faker->regexify('[0-6] mois'));

            //Définition des compétences requises en fonction de la formation
            $competencesRequises = "";
            if($intituleFormation=="Testeur"){
              $competencesRequises="Niveau génaral en test de programmes";
            }

            if($intituleFormation=="Programmeur Symphony"){
              $competencesRequises="Compétences en Symphony";
            }

            if($intituleFormation=="Concepteur"){
              $competencesRequises="Niveau génaral en tant que Concepteur";
            }

            if($intituleFormation=="Programmeur C++"){
              $competencesRequises="Compétences en C++";
            }

            if($intituleFormation=="Programmeur Assembleur"){
              $competencesRequises="Compétences en Assembleur";
            }

            if($intituleFormation=="Programmeur Web"){
              $competencesRequises="Compétences en Web";
            }

            $stage -> setCompetencesRequises($competencesRequises);

            //Définition de l'expérience requise en fonction du niveau de la formation
            $experiencesRequises="";

            if($niveauFormation=="1° Année"){
              $experiencesRequises="Aucune";
            }

            if($niveauFormation=="2° Année"){
              $experiencesRequises="2 mois en entreprise";
            }

            $stage -> setExperiencesRequises($experiencesRequises);

            $stage -> setEmail($faker->companyEmail());

            // Création de la relation Stage --> Formation
            $stage -> addFormation($formations);

            /****** Définir et mettre à jour l'entreprise ******/
            // Sélectionner une entreprise au hasard parmi les 4 enregistrées dans $tableauEntreprises
            $numEntreprise = $faker->numberBetween($min = 0, $max = 3);
            // Création de la relation Stage --> Entreprise
            $stage -> setEntreprise($tableauEntreprises[$numEntreprise]);
            // Création relation Entreprise --> Stage
            $tableauEntreprises[$numEntreprise] -> addStage($stage);
            // Persister les objets modifiés
            $manager->persist($stage);
            $manager->persist($tableauEntreprises[$numEntreprise]);
          }
      }
      // Envoi des objets créés en base de données
      $manager->flush();
    }
}
