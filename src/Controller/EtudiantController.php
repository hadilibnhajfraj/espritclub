<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'app_etudiant')]
    public function index(): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
        ]);
    }
    #[Route('/afficherStudent', name: 'afficheS')]
    public function afficheStudent(StudentRepository $r): Response
    { //recuperer le repo
        $student = $r->findAll();
        return $this->render('etudiant/affiche.html.twig', [
            'student' => $student,
        ]);
    }
    #[Route('/addStudent', name: 'addStudent')]
    public function addStudent(ManagerRegistry $doctrine, Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentFormType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $doctrine->getManager();
            $em->persist($student); //l'action du l'ajout
            $em->flush();
            return $this->redirectToRoute("afficheS");
        }
        return $this->renderForm(
            "etudiant/addS.html.twig",
            array("f" => $form)
        );
    }
    #[Route('/afficherStudentEmail', name: 'afficheS')]
    public function afficheStudentEmail(StudentRepository $r): Response
    { //recuperer le repo
        $student = $r->findStudentByEmail();
        return $this->render('etudiant/list.html.twig', [
            'student' => $student,
        ]);
    }
    #[Route('/searchStudentByAVG', name: 'searchStudentByAVG')]
    public function searchStudentByAVG(Request $request, StudentRepository $student)
    {

        $students = $student->findStudentByEmail();
        $searchForm = $this->createForm(StudentFormType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted()) {
            //récupérer le contenu de l'input min
            $minMoy = $searchForm['min']->getData();
            $maxMoy = $searchForm['max']->getData();
            $resultOfSearch = $student->searchByAVG($minMoy, $maxMoy);
            return $this->renderForm('etudiant/searchStudentByAVG.html.twig', [
                'Students' => $resultOfSearch,
                'searchStudentByAVG' => $searchForm,
            ]);
        }
        return $this->renderForm(
            'etudiant/searchStudentByAVG.html.twig',
            array(
                'Students' => $students, 'searchStudentByAVG' => $searchForm,
            )
        );
    }
}
