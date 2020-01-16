<?php
namespace App\Controller;

use App\Entity\Soldier;

use App\Form\SoldierFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SoldierController extends AbstractController
{
    /**
     * @Route("/soldier/add/{name}")
     */
    public function index($name){
        $unit_id=1;
        $entityManager = $this->getDoctrine()->getManager();
        $unit=$this->getDoctrine()
            ->getRepository(MilitaryUnit::class)
            ->find($unit_id);
        $soldier= new Soldier();
        $soldier->setFirstName($name);
        $soldier->setMilitaryUnit($unit);
        $entityManager->persist($soldier);
        $entityManager->flush();
        return new Response(
            '<html><body>Success</body></html>'
        );
    }

    /**
     * @Route("/soldier/new")
     */
    public function new(Request $request){
        $soldier= new Soldier();
        $form=$this->createForm(SoldierFormType::class,$soldier);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $soldier=$form->getData();
            $entityManager=$this->getDoctrine()->getManager();
            $soldier_rep=$entityManager->getRepository(Soldier::class);
            $entityManager->persist($soldier);
            $entityManager->flush();
        }
        return $this->render('soldier\new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/soldier/all")
     */
    public function all(Request $request){
        $entityManager=$this->getDoctrine()->getManager();
        $soldiers_rep=$entityManager->getRepository(Soldier::class);
        $search_soldier= new Soldier();
        $form=$this->createForm(SoldierFormType::class,$search_soldier);

        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {
            $search_soldier = $form->getData();
            $soldiers = $soldiers_rep->find($search_soldier->getFirstName());
            return $this->render('soldier\all.html.twig', ['soldiers' => $soldiers,'form'=>$form->createView()]);
        }
        $soldiers=$soldiers_rep->findAll();
        return $this->render('soldier\all.html.twig', ['soldiers' => $soldiers,'form'=>$form->createView()]);
    }

    /**
     * @Route("/soldier/edit/{id}",name="edit",methods={"GET","POST"})
     */
    public function edit(Request $request,$id): Response
    {
        $entityManager=$this->getDoctrine()->getManager();
        $soldier_rep=$entityManager->getRepository(Soldier::class);
        $soldier=$soldier_rep->find($id);
        $form=$this->createForm(SoldierFormType::class,$soldier);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $soldier=$form->getData();
            $entityManager->persist($soldier);
            $entityManager->flush();
            return $this->redirect('/soldier/all');
        }
        return $this->render('soldier\new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/soldier/delete/{id}",name="delete")
     */
    public function delete(Request $request,$id){
        $entityManager=$this->getDoctrine()->getManager();
        $soldier_rep=$entityManager->getRepository(Soldier::class);
        $soldier=$soldier_rep->find($id);
        $entityManager->remove($soldier);
        $entityManager->flush();
        return $this->redirect('/soldier/all');
    }
}