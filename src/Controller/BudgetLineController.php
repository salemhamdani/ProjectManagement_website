<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\BudgetLine;
use App\Entity\Project;
use App\Form\ActivityType;
use App\Form\BudgetLineType;
use App\Service\Graphics;
use App\Service\Validator;
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
     * @Route("/create/{id}", name="createBudgetLine")
     */
    public function handle_budgetLine(Request $request,EntityManagerInterface $manager, Validator $validator,Project $project)
    {
        $message='BudgetLine updated';
        $budgetLine=new BudgetLine();
        $used=0;
        $available=0;
        $name=$project->getName();
        $form=$this->createForm(BudgetLineType::class,$budgetLine);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $budgetLine->setProject($project);
            $manager->persist($budgetLine);
            if ($validator->validateBudgetLine($budgetLine))
            { $manager->flush();
                $this->addFlash('success', 'BudgetLine created');
                return $this->redirectToRoute("budgetLines");

            }else
            {
                $this->addFlash('error', 'the percentage of budgetLine exceeded the available percentage !');
                    return $this->redirectToRoute("createBudgetLine",['id'=>$project->getId()]);
            }

        }
        return  $this->render('budget_line/create.html.twig',[
            'title'=>"BudgetLine",
            'form'=>$form->createView(),
            'editMode'=>false,
            'used'=>$used,
            'available'=>$available,
            'proj_name'=>$name
        ]);
    }
    /**
     * @Route("/update/{id}", name="updateBudgetLine")
     */
    public function update_budgetLine(Request $request,EntityManagerInterface $manager,BudgetLine $budgetLine, Graphics $graphics, Validator $validator)
    {
        $used=$graphics->budgetLineUsedMoney($budgetLine);
        $available=$graphics->budgetLineAvailableMoney($budgetLine);
        $name="";
        $form=$this->createForm(BudgetLineType::class,$budgetLine);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($budgetLine);
            if ($validator->validateBudgetLine($budgetLine))
            { $manager->flush();
                $this->addFlash('success', 'BudgetLine updated');
                return $this->redirectToRoute("budgetLines");

            }else
            {
                $this->addFlash('error', 'the percentage of budgetLine exceeded the available percentage !');
                return $this->redirectToRoute("updateBudgetLine",['id'=>$budgetLine->getId()]);
            }

        }
        return  $this->render('budget_line/create.html.twig',[
            'title'=>"BudgetLine",
            'form'=>$form->createView(),
            'editMode'=>true,
            'used'=>$used,
            'available'=>$available,
            'proj_name'=>$name
        ]);
    }
    /**
     * @Route("/delete/{id}", name="deleteBudgetLine")
     */
    public function delete_BudgetLine(EntityManagerInterface $manager,BudgetLine $budgetLine)
    {
        $manager->remove($budgetLine);
        $manager->flush();
        $this->addFlash('success', 'BudgetLine deleted');
        return $this->redirectToRoute('budgetLines');
    }
}
