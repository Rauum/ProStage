<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProStageController extends AbstractController
{
  public function index(): Response
  {

    //Recuperer le repository de l'entité stage
    $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

    //Recuperer les ressources enregistrées en BD
    $stages = $repositoryStage->findAll();

    //Envoyer les ressources récupérées à la vue chargée de les afficher
    return $this->render('pro_stage/index.html.twig', ['stages'=>$stages]);

  }

  public function entreprises(): Response
  {
    //Recuperer le repository de l'entité stage
    $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

    //Recuperer les ressources enregistrées en BD
    $entreprises = $repositoryEntreprise->findAll();

    return $this->render('pro_stage/entreprises.html.twig', ['entreprises'=>$entreprises]);
  }

  public function formations(): Response
  {
    //Recuperer le repository de l'entité stage
    $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

    //Recuperer les ressources enregistrées en BD
    $formations = $repositoryFormation->findAll();

    return $this->render('pro_stage/formations.html.twig', ['formations'=>$formations]);
  }

  public function stage($id): Response
  {
    //Recuperer le repository de l'entité stage
    $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

    //Recuperer les ressources enregistrées en BD
    $stage = $repositoryStage->find($id);

    return $this->render('pro_stage/stage.html.twig',
    ['stage' => $stage]);
  }
}
