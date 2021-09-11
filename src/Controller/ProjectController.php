<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
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
    public function addProject(Request $request,EntityManagerInterface $manager,Project $project= null){
       if(!$project){
           $project=new Project();
       }

        $form=$this->createForm(ProjectType::class,$project);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($project);
            $manager->flush();
            return $this->redirectToRoute("projects");
        }
        return  $this->render('create.html.twig',[
            'title'=>" Project",
           'form'=>$form->createView(),
            'editMode'=>$project->getId() !==null
        ]);

    }
    /**
     * @Route ("/project/delete/{id}",name="delete_project")
     */
    public function remove_project(EntityManagerInterface $manager,Project $project){
        $manager->remove($project);
        $manager->flush();
        return $this->redirectToRoute('projects');
    }
}
