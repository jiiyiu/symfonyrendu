<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\FormtacheType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TachesController extends AbstractController
{
    /**
     * @Route("/taches", name="taches")
     */
    public function index(EntityManagerInterface $entityManager,Request $request)
    {
        $taches= new  tache();
        $form = $this->createForm(FormtacheType::class, $taches);
        $taches->setEtat(false);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $tache= $form->getData();

            $entityManager->persist($tache);
            $entityManager->flush();
        }

        $TachesRepo = $this->getDoctrine()
            ->getRepository(Tache::class)
            ->findAll();
            dump($TachesRepo);
        return $this->render('taches/index.html.twig', [
            'controller_name' => 'TachesController',
            'taches' => $TachesRepo,
            'formtache'=> $form->createView()
        ]);
    }
}