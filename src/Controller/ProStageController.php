<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use App\Repository\FormationRepository;
use App\Repository\EntrepriseRepository;

class ProStageController extends AbstractController
{
  public function index(StageRepository $repositoryStage): Response
  {
    //Recuperer les ressources enregistrées en BD
    $stages = $repositoryStage->findByPageAcceuil();

    //Envoyer les ressources récupérées à la vue chargée de les afficher
    return $this->render('pro_stage/index.html.twig', ['stages'=>$stages]);

  }

  public function entreprises(EntrepriseRepository $repositoryEntreprise): Response
  {
    //Recuperer les ressources enregistrées en BD
    $entreprises = $repositoryEntreprise->findAll();

    return $this->render('pro_stage/entreprises.html.twig', ['entreprises'=>$entreprises]);
  }

  public function formations(FormationRepository $repositoryFormation): Response
  {
    //Recuperer les ressources enregistrées en BD
    $formations = $repositoryFormation->findAll();

    return $this->render('pro_stage/formations.html.twig', ['formations'=>$formations]);
  }

  public function stage(Stage $stage): Response
  {
    return $this->render('pro_stage/stage.html.twig', ['stage' => $stage]);
  }

  public function  afficherStagesParEntreprises(StageRepository $repositoryStage, $nom)
  {
    //Recuperer les ressources enregistrées en BD
    $stages = $repositoryStage->findByNomEntreprise($nom);

    //Envoyer les ressources récupérées à la vue chargée de les afficher
    return $this->render('pro_stage/afficherStagesParEntreprises.html.twig', ['stages'=>$stages]);

  }

  public function  afficherStagesParFormations(StageRepository $repositoryStage, $intitule)
  {
    //Recuperer les ressources enregistrées en BD
    $stages = $repositoryStage->findByNomFormation($intitule);

    //Envoyer les ressources récupérées à la vue chargée de les afficher
    return $this->render('pro_stage/afficherStagesParEntreprises.html.twig', ['stages'=>$stages]);

  }

}
