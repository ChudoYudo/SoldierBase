<?php
namespace App\Controller;

use App\Entity\MilitaryUnit;
use App\Entity\Soldier;

use App\Form\SoldierFormType;
use App\Repository\SoldierRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Maker\MakeSerializerEncoder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

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
     * @Route("/soldier/newm")
     */
    public function newm(Request $request){
        $entityManager=$this->getDoctrine()->getManager();
        $mil_rep=$entityManager->getRepository(MilitaryUnit::class);
        $i=26;
        while (true) {
            $soldier= new Soldier();
            $unit=$mil_rep->find(1);
            $soldier->setFirstName("nam".$i);
            $soldier->setLastName("last".$i);
            $soldier->setMilitaryUnit($unit);
            $entityManager->persist($soldier);
            $entityManager->flush();
            $i=$i+1;
            if ($i==100){break;}
        }
        return new Response("Success");

    }

    /**
     * @Route("/soldier/change")
     */
    public function change(Request $request){
        $id=$request->request->get('id');
        $entityManager=$this->getDoctrine()->getManager();
        $soldier_rep=$entityManager->getRepository(Soldier::class);
        $soldier=$soldier_rep->find($id);
        $soldier->setFirstName($request->request->get('first_name'));
        $soldier->setLastName($request->request->get('last_name'));
        $soldier->setThirdName($request->request->get('third_name'));
        if ($request->request->get('birthday_date')!=0) {
            $date = \DateTime::createFromFormat('d/m/Y', $request->request->get('birthday_date'));
            $soldier->setBirthdayDate($date);
        }

        $entityManager->persist($soldier);
        $entityManager->flush();

        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent("success");

        return new $response;
    }
    /**
     * @Route("/soldier/addnew")
     */
    public function addnew(Request $request){
        $entityManager=$this->getDoctrine()->getManager();
        $soldier= new Soldier();
        $mil_rep=$entityManager->getRepository(MilitaryUnit::class);
        $unit=$mil_rep->find(1);


        $soldier->setMilitaryUnit($unit);
        $soldier->setFirstName($request->request->get('first_name'));
        $soldier->setLastName($request->request->get('last_name'));
        $soldier->setThirdName($request->request->get('third_name'));
        if ($request->request->get('birthday_date')!=0) {
            $date = \DateTime::createFromFormat('d/m/Y', $request->request->get('birthday_date'));
            $soldier->setBirthdayDate($date);
        }

        $entityManager->persist($soldier);
        $entityManager->flush();
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent("success");

        return new $response;
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
     * @Route("/soldier/delete",name="delete")
     */
    public function delete(Request $request){
        $id=$request->request->get('id');

        $entityManager=$this->getDoctrine()->getManager();
        $soldier_rep=$entityManager->getRepository(Soldier::class);
        $soldier=$soldier_rep->find($id);
        $entityManager->remove($soldier);
        $entityManager->flush();
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent("success");

        return new $response;
    }

    public function soldiersArrayToJson($soldiers){
        $soldiers_array=array();
        foreach ($soldiers as $soldier){
            $soldiers_array[]= array(
                'id'=>$soldier->getId(),
                'first_name'=>$soldier->getFirstName(),
                'last_name'=>$soldier->getLastName(),
                'third_name'=>$soldier->getThirdName(),
                'milU'=>$soldier->getMilitaryUnit()->getName(),
                'birthday_date'=>$soldier->getBirthdayDateFormat('d/m/Y')

            );
        }
        return json_encode($soldiers_array);
    }

    public function soldierToJson($soldier){

        $soldier_obj= array(
        'id'=>$soldier->getId(),
        'first_name'=>$soldier->getFirstName(),
        'last_name'=>$soldier->getLastName(),
        'third_name'=>$soldier->getThirdName(),
        'birthday_date'=>$soldier->getBirthdayDate(),
        'milU'=>$soldier->getMilitaryUnit()->getName()
        );
        return json_encode($soldier_obj);
    }



    /**
     * @Route("/soldier/get/{id}",name="getsoldier")
     */
    public function getById(Request $request, $id){
        $entityManager=$this->getDoctrine()->getManager();
        $soldiers_rep=$entityManager->getRepository(Soldier::class);
        $soldier=$soldiers_rep->find($id);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent($this->soldierToJson($soldier));
        return $response;

    }

    /**
     * @Route("/soldier/search",name="search")
     */
    public function search(Request $request){
        
        exit;
        $fname=$request->request->get('first_name');
        $entityManager=$this->getDoctrine()->getManager();
        $this->getDoctrine()->getRepository();

        $soldier_rep=$entityManager->getRepository(Soldier::class);
        $q=$soldier_rep->
        var_dump($soldiers->getFirstName());
        exit;
//        $soldier=$soldier_rep->find($id);
//        $entityManager->remove($soldier);
//        $entityManager->flush();
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent("success");

        return new $response;
    }


}
