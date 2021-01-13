<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProStageController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('pro_stage/index.html.twig');
    }

    public function entreprises(): Response
    {
        return $this->render('pro_stage/entreprises.html.twig');
    }

    public function formations(): Response
    {
        return $this->render('pro_stage/formations.html.twig');
    }

    public function stage($id): Response
    {
        return $this->render('pro_stage/stage.html.twig',
        ['id' => $id]);
    }
}
