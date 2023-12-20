<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\ClassroomFormType;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    // 1ere facon pour affichage 
    #[Route('/listclassroom', name: 'app_listclassroom')]

   // public function list(EntityManagerInterface $entityManager): Response
    //{
      //  $repo=$entityManager->getRepository(Classroom::class);
        //utiliser la fonction finall()
        //$classroom=$repo->findAll();
        //return $this->render('classroom/listclassroom.html.twig', [
          //  'classroom' => $classroom,
        //]);
   // }
    //2 eme facon pour affichage 
    #[Route('/listclassroom', name: 'app_listclassroom')]
    public function afficheClassroom(ClassroomRepository $r): Response
    {//recuperer le repo
        $classroom=$r->findAll();
        return $this->render('classroom/listclassroom.html.twig', [
            'classroom' => $classroom,
        ]);
    }
    #[Route('/supprimerC/{id}', name: 'SupprimerC')]
    public function supprimerC($id,ClassroomRepository $r): Response
    {
        //Récupérer classroom à supprimer
        $classroom=$r->find($id);
        //Action de suppression
     //récupérer entity manager
     $em=$this->getDoctrine()->getManager();
     //supprimer
     $em->remove($classroom);
     $em->flush();
        return $this->redirectToRoute('app_listclassroom');
    }
    #[Route('/addClassroom', name: 'addclassroom')]
    public function addclassroom(ManagerRegistry $doctrine,Request $request){
  $classroom= new Classroom();
  $form=$this->createForm(ClassroomFormType::class,$classroom);
  $form->handleRequest($request);
        if($form->isSubmitted()){
            $em =$doctrine->getManager() ;
            $em->persist($classroom);//l'action du l'ajout
            $em->flush();
            return $this->redirectToRoute("afficheC");}
        return $this->renderForm("classroom/addClassroom.html.twig",
            array("f"=>$form));
     }
     #[Route('/modiffierClassroom/{id}', name: 'ModiffierC')]
     public function modiffierclassroom(ManagerRegistry $doctrine,Request $request ,ClassroomRepository $r,$id){
         //recuperer classroom à modiffier
         $classroom= $r->find($id);;
         $form=$this->createForm(ClassroomFormType::class,$classroom);
         $form->handleRequest($request);
         if($form->isSubmitted()){
             $em =$doctrine->getManager() ;
             $em->flush();
             return $this->redirectToRoute("app_listclassroom");}
         return $this->renderForm("classroom/addClassroom.html.twig",
             array("f"=>$form));
      }

}
