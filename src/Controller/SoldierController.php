<?php
namespace App\Controller;

use App\Entity\Soldier;

use App\Form\SoldierFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Maker\MakeSerializerEncoder;
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
        $soldiers=$soldiers_rep->findAll();
        $json=$this->soldiersArrayToJson($soldiers);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent($json);

        return $response;
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

    public function soldiersArrayToJson($soldiers){
        $soldiers_array=array();
        foreach ($soldiers as $soldier){
            $soldiers_array[]= array(
                'id'=>$soldier->getId(),
                'first_name'=>$soldier->getFirstName(),
                'last_name'=>$soldier->getLastName(),
                'third_name'=>$soldier->getThirdName(),
                'milU'=>$soldier->getMilitaryUnit()->getNAme()
            );
        }
        return json_encode($soldiers_array);
    }
}
