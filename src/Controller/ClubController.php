<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club')]
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }
    #[Route('/getName/{titre}', name: 'detailF')]
    public function getName($titre): Response
    {
        return $this->render('club/detail.html.twig', [
            't' => $titre
        ]);
    }
    #[Route('/list', name: 'app_list')]
    public function list(): Response
    {
        $formations = array(
            array('ref' => 'f1', 'Titre' => 'Formation Symfony
4', 'Description' => 'formation pratique', 'nb_participants' => 19),
            array(
                'ref' => 'f2', 'Titre' => 'Formation SOA',
                'Description' => 'formation theorique', 'nb_participants' => 0
            ),
            array(
                'ref' => 'f3', 'Titre' => 'Formation Angular',
                'Description' => 'formation theorique', 'nb_participants' => 12
            )
        );
        return $this->render('club/list.html.twig', [
            'formations' => $formations,
        ]);
    }
}
