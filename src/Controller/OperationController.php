<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\BudgetLine;
use App\Entity\Operation;
use App\Form\ActivityType;
use App\Form\OperationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OperationController
 * @package App\Controller
 * @Route("operation")
 */
class OperationController extends AbstractController
{
    /**
     * @Route("/operations", name="operations")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $operations=$manager->getRepository(Operation::class)->findAll();
        return $this->render('operation/operations.html.twig', [
           'operations'=>$operations
        ]);
    }
    /**
     * @Route("/create", name="createOperation")
     * @Route("/update/{id}", name="updateOperation")
     */
    public function handle_operation(Request $request,EntityManagerInterface $manager,Operation $operation= null)
    {
        if(!$operation){
            $operation=new Operation();
        }

        $form=$this->createForm(OperationType::class,$operation);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($operation);
            $manager->flush();
            return $this->redirectToRoute("operations");
        }
        return  $this->render('create.html.twig',[
            'title'=>"Operation",
            'form'=>$form->createView(),
            'editMode'=>$operation->getId() !==null
        ]);
    }
    /**
     * @Route("/delete/{id}", name="deleteOperation")
     */
    public function delete_operation(EntityManagerInterface $manager,Operation $operation)
    {
        $manager->remove($operation);
        $manager->flush();
        return $this->redirectToRoute('operations');
    }
    /**
     * @Route ("/consult/{id}",name="consultOperation")
     */
    public function  consult_operation():Response{
return $this->render('operation/consult.html.twig',[

]);
    }
}
