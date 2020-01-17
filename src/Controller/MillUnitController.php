<?php

namespace App\Controller;

use App\Entity\MilitaryUnit;
use App\Form\MillitaryUnitFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MillUnitController extends AbstractController
{
    /**
     * @Route("/millunit", name="mill_unit")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MillUnitController.php',
        ]);
    }

    /**
     * @Route("/millunit/new", name="mill_unit")
     */
    public function new(Request $request){
        $unit= new MilitaryUnit();
        $form=$this->createForm(MillitaryUnitFormType::class,$unit);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $unit=$form->getData();
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($unit);
            $entityManager->flush();
        }
        return $this->render('milUnit/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
