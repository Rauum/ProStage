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
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EntrepriseType;
use App\Form\StageType;


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
    return $this->render('pro_stage/afficherStagesParEntreprises.html.twig', ['stages'=>$stages, 'nom'=>$nom]);

  }

  public function  afficherStagesParFormations(StageRepository $repositoryStage, $intitule)
  {
    //Recuperer les ressources enregistrées en BD
    $stages = $repositoryStage->findByNomFormation($intitule);

    //Envoyer les ressources récupérées à la vue chargée de les afficher
    return $this->render('pro_stage/afficherStagesParFormations.html.twig', ['stages'=>$stages, 'intitule'=>$intitule]);

  }

  public function ajouterEntreprise(Request $request, EntityManagerInterface $manager)
  {
    //Creation d'une entreprise vierge sui sera remplie par le formulaire
    $entreprise = new Entreprise();

    // Création du formulaire permettant de saisir une entreprise
    $formulaireEntreprise= $this->createForm(EntrepriseType::class, $entreprise);

    /* On demande au formulaire d'analyser la dernière requête Http. Si le tableau POST contenu
    dans cette requête contient des variables nom, adresse, etc. alors la méthode handleRequest()
    récupère les valeurs de ces variables et les affecte à l'objet $entreprise*/
    $formulaireEntreprise->handleRequest($request);

    if ($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
         {
            // Enregistrer la ressource en base de donnéelse
            $manager->persist($entreprise);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('pro_stage_acceuil');
         }

    //Afficher la page présentant le formulaire d'ajout d'une entreprise
    return $this->render('pro_stage/ajoutModifEntreprise.html.twig', ['vueFormulaire' => $formulaireEntreprise->createView(), 'action'=>"ajouter"]);

  }

  public function modifierEntreprise(Request $request, EntityManagerInterface $manager, Entreprise $entreprise)
  {
    // Création du formulaire permettant de modifier une entreprise
    $formulaireEntreprise= $this->createForm(EntrepriseType::class, $entreprise);

    /* On demande au formulaire d'analyser la dernière requête Http. Si le tableau POST contenu
    dans cette requête contient des variables nom, adresse, etc. alors la méthode handleRequest()
    récupère les valeurs de ces variables et les affecte à l'objet $entreprise*/
    $formulaireEntreprise->handleRequest($request);

    if ($formulaireEntreprise->isSubmitted() )
         {
            // Enregistrer la ressource en base de donnéelse
            $manager->persist($entreprise);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('pro_stage_acceuil');
         }

    //Afficher la page présentant le formulaire d'ajout d'une entreprise
    return $this->render('pro_stage/ajoutModifEntreprise.html.twig', ['vueFormulaire' => $formulaireEntreprise->createView(), 'action'=>"modifier"]);

  }

  public function ajouterStage(Request $request, EntityManagerInterface $manager)
  {
    //Creation d'un stage vierge sui sera remplie par le formulaire
    $stage = new Stage();

    // Création du formulaire permettant de saisir une entreprise
    $formulaireStage= $this->createForm(StageType::class, $stage);

    /* On demande au formulaire d'analyser la dernière requête Http. Si le tableau POST contenu
    dans cette requête contient des variables nom, adresse, etc. alors la méthode handleRequest()
    récupère les valeurs de ces variables et les affecte à l'objet $entreprise*/
    $formulaireStage->handleRequest($request);

    if ($formulaireStage->isSubmitted() && $formulaireStage->isValid())
         {
            // Enregistrer la ressource en base de donnéelse
            $manager->persist($stage);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('pro_stage_acceuil');
         }

    //Afficher la page présentant le formulaire d'ajout d'une entreprise
    return $this->render('pro_stage/ajoutModifStage.html.twig', ['vueFormulaire' => $formulaireStage->createView(), 'action'=>"ajouter"]);

  }

}
