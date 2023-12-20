<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Classroom;
use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
class VoitureController extends AbstractController
{
    #[Route('/voiture', name: 'app_voiture')]
    public function index(): Response
    {
        return $this->render('voiture/index.html.twig', [
            'controller_name' => 'VoitureController',
        ]);
    }
    #[Route('/getVoiture/{vitesse}/{puissance}', name: 'detailV')]
    public function getVoiture($vitesse,$puissance): Response
    {
        return $this->render('voiture/detail.html.twig', [
            'voiture' => $vitesse,
            'puissance'=>$puissance
        ]);
    }
   // #[Route('/afficher', name: 'app_list')]
   // public function afficherVoiture(): Response
    //{
        //$voitures = array(
           // array('id'=>1, 'marque'=>'BMW', 'vitesse'=>240, 'puissance'=>10),
            //array(
             //   'id'=>2, 'marque'=>'Ford', 'vitesse'=>200, 'puissance'=>6
            //),
            //array(
                //'id'=>3, 'marque'=>'Audi', 'vitesse'=>240, 'puissance'=>8
            //),
            //array('id'=>4, 'marque'=>'Peugeot', 'vitesse'=>200, 'puissance'=>4)
        //);
        //return $this->render('voiture/affiche.html.twig', [
          //  'voitures' => $voitures,
        //]);
    //}
    #[Route('/afficher', name: 'app_list')]
   public function list(EntityManagerInterface $entityManager): Response
    {
        $repo=$entityManager->getRepository(Voiture::class);
        //utiliser la fonction finall()
        $voitures=$repo->findAll();
        return $this->render('voiture/affiche.html.twig', [
            'voitures' => $voitures,
        ]);
    }
    #[Route('/supprimerV/{id}', name: 'SuprrimerV')]
   public function Supprimer($id): Response
    {
      
        return $this->render('voiture/suppression.html.twig', [
            'id' => $id,
           
        ]);
    }
}
