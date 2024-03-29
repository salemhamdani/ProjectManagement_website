<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\BudgetLine;
use App\Entity\Operation;
use App\Entity\Project;
use App\Form\ActivityType;
use App\Form\OperationType;
use App\Form\OperationUpType;
use App\Service\Validator;
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
     * @Route("/update/{id}", name="updateOperation")
     */
    public function update_operation(EntityManagerInterface $manager,Operation $operation,Request $request,Validator $validator){
        $form=$this->createForm(OperationUpType::class,$operation,['project'=>$operation->getBudgetLine()->getProject()->getId()]);
        $form->handleRequest($request);
        $paymentTraces=$operation->getPaymentTrace();
        $paymentTranches=$operation->getPaymentTranche();
        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($operation);
            if ($validator->validateOperation($operation)) {
                $manager->flush();
                $this->addFlash('success', 'Operation updated !');
                return $this->redirectToRoute('update_project',['id'=>$operation->getActivity()->getProject()->getId()]);
            }else {
                $this->addFlash('error', 'the price of operation exceeded the budget !');
                return $this->redirectToRoute("updateOperation",['id'=>$operation->getId()]);
            }
        }
        return  $this->render('operation/update.html.twig',[
            'title'=>"Operation",
            'form'=>$form->createView(),
            'editMode'=>$operation->getId() !==null,
            'paymentTraces'=>$paymentTraces,
            'paymentTranches'=>$paymentTranches
        ]);
    }
    /**
     * @Route("/create/{id}", name="createOperation", defaults={"id"=0})
     */
    public function create_operation(Request $request,EntityManagerInterface $manager,Project $project=null,Validator $validator)
    {
        $operation=new Operation();
        $form=$this->createForm(OperationType::class,$operation,['project'=>$project->getId()]);
        $form->handleRequest($request);
        $name="";
        if ($project){
            $name=$project->getName();
        }
        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($operation);
            if ($validator->validateOperation($operation)) {
                $manager->flush();
                $this->addFlash('success', 'Operation created !');
                return $this->redirectToRoute('update_project',['id'=>$operation->getActivity()->getProject()->getId()]);
            }else {
                $this->addFlash('error', 'the price of operation exceeded the budget !');
                return $this->redirectToRoute("createOperation",['id'=>$operation->getActivity()->getProject()->getId() ]);
            }
        }
        return  $this->render('operation/create.html.twig',[
            'title'=>"Operation",
            'form'=>$form->createView(),
            'proj_name'=>$name,
            'project'=> $project!== null
        ]);
    }
    /**
     * @Route("/delete/{id}", name="deleteOperation")
     */
    public function delete_operation(EntityManagerInterface $manager,Operation $operation)
    {
        $id=$operation->getActivity()->getProject()->getId();
        if ($operation->getPaymentTrace()->isEmpty() AND $operation->getPaymentTranche()->isEmpty())
        {
            $manager->remove($operation);
            $manager->flush();
            $this->addFlash('success', 'Operation deleted !');
        }else {
            $this->addFlash('error', 'Operation can not be deleted because it still contains payment tranches or payment traces !');
        }
        return $this->redirectToRoute('update_project',['id'=>$id]);
    }

}
