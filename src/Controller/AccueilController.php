<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Tache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FormutilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(EntityManagerInterface $entityManager, Request $request)
    {

        $utilisateur= new  utilisateur();
        $form = $this->createForm(FormutilisateurType::class, $utilisateur);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $utilisateur= $form->getData();


            $entityManager->persist($utilisateur);
            $entityManager->flush();

        }

        $UtilisateurRepo = $this->getDoctrine()
            ->getRepository(Utilisateur::class)
            ->findAll();

        $TacheRepo = $this->getDoctrine()
            ->getRepository(Tache::class);

        $lenght= count($UtilisateurRepo);

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilControllerController',
            'utilisateur'=>$UtilisateurRepo,
            'lenght'=>$lenght,
            'form'=>$form->createView(),
            'tache' => $TacheRepo
        ]);

    }
}