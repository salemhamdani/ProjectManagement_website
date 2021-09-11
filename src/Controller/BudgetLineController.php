<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\BudgetLine;
use App\Form\ActivityType;
use App\Form\BudgetLineType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BudgetLineController
 * @package App\Controller
 * @Route("budgetLine")
 */
class BudgetLineController extends AbstractController
{
    /**
     * @Route("/budgetLines", name="budgetLines")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $budgetLines=$manager->getRepository(BudgetLine::class)->findAll();
        return $this->render('budget_line/budgetLines.html.twig', [
           'budgetLines'=>$budgetLines
        ]);
    }
    /**
     * @Route("/create", name="createBudgetLine")
     * @Route("/update/{id}", name="updateBudgetLine")
     */
    public function handle_activity(Request $request,EntityManagerInterface $manager,BudgetLine $budgetLine= null)
    {
        if(!$budgetLine){
            $budgetLine=new BudgetLine();
        }

        $form=$this->createForm(BudgetLineType::class,$budgetLine);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($budgetLine);
            $manager->flush();
            return $this->redirectToRoute("budgetLines");
        }
        return  $this->render('create.html.twig',[
            'title'=>"BudgetLine",
            'form'=>$form->createView(),
            'editMode'=>$budgetLine->getId() !==null
        ]);
    }
    /**
     * @Route("/delete/{id}", name="deleteBudgetLine")
     */
    public function delete_BudgetLine(EntityManagerInterface $manager,BudgetLine $budgetLine)
    {
        $manager->remove($budgetLine);
        $manager->flush();
        return $this->redirectToRoute('budgetLines');
    }
}
