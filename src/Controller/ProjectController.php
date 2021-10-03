<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Operation;
use App\Entity\Project;
use App\Form\OperationType;
use App\Form\ProjectType;
use App\Service\Graphics;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\CollectionAdd;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/projects", name="projects")
     */
    public function index(EntityManagerInterface $manager): Response
    {   $projects=$manager->getRepository(Project::class)->findAll();
        return $this->render('project/projects.html.twig', [
           'projects'=>$projects,

        ]);
    }
    /**
     * @Route ("/project/create", name="create_project")
     * @Route("/project/update/{id}",name="update_project")
     */
    public function addProject(Request $request,EntityManagerInterface $manager,Project $project= null, Graphics $graphics){
        $projectBudgets=null;
       if(!$project){
           $project=new Project();
       }else{
           $projectBudgets=$graphics->projectBudgets($project);
       }
       $budgetLines=$project->getBudgetlines();
       $activities=$project->getActivities();
        $operations=new ArrayCollection();
       foreach ($activities as $act) {
           $ops=$act->getOperations();
           foreach ($ops as $op){
               $operations->add($op);
           }
           }

        $form=$this->createForm(ProjectType::class,$project);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($project);
            $manager->flush();
            $this->addFlash('success', 'Project created !');
            return $this->redirectToRoute("projects");
        }
        return  $this->render('project/create.html.twig',[
            'title'=>"Project",
           'form'=>$form->createView(),
            'editMode'=>$project->getId() !==null,
            'project'=>$project,
             'projectBudgets'=>$projectBudgets,
            'operations'=>$operations,
            'activities'=>$activities,
            'budgetLines'=>$budgetLines
        ]);

    }
    /**
     * @Route ("/project/delete/{id}",name="delete_project")
     */
    public function remove_project(EntityManagerInterface $manager,Project $project){
        $manager->remove($project);
        $manager->flush();
        $this->addFlash('success', 'Project deleted successfully !');
        return $this->redirectToRoute('projects');
    }
}
