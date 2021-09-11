<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Project;
use App\Form\ActivityType;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActivityController
 * @package App\Controller
 * @Route("activity")
 */
class ActivityController extends AbstractController
{
    /**
     * @Route("/activities", name="activities")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $activities=$manager->getRepository(Activity::class)->findAll();
        return $this->render('activity/activities.html.twig', [
            'activities' => $activities,
        ]);
    }
    /**
     * @Route("/create", name="createActivity")
     * @Route("/update/{id}", name="updateActivity")
     */
    public function handle_activity(Request $request,EntityManagerInterface $manager,Activity $activity= null)
    {
        if(!$activity){
            $activity=new Activity();
        }

        $form=$this->createForm(ActivityType::class,$activity);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($activity);
            $manager->flush();
            return $this->redirectToRoute("activities");
        }
        return  $this->render('create.html.twig',[
            'title'=>"Activity",
            'form'=>$form->createView(),
            'editMode'=>$activity->getId() !==null
        ]);
    }
    /**
     * @Route("/delete/{id}", name="deleteActivity")
     */
    public function delete_activity(EntityManagerInterface $manager,Activity $activity)
    {
        $manager->remove($activity);
        $manager->flush();
        return $this->redirectToRoute('activities');
    }
}
