<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\TraceType;
use App\Form\ActivityType;
use App\Form\TraceTypeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TraceTypeController
 * @package App\Controller
 * @Route("traceType")
 */
class TraceTypeController extends AbstractController
{
    /**
     * @Route("/traceTypes", name="traceTypes")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $traceTypes=$manager->getRepository(TraceType::class)->findAll();
        return $this->render('trace_type/traceTypes.html.twig', [
        'TraceTypes'=>$traceTypes
        ]);
    }
    /**
     * @Route("/create", name="createTraceType")
     * @Route("/update/{id}", name="updateTraceType")
     */
    public function handle_traceType(Request $request,EntityManagerInterface $manager,TraceType $traceType= null)
    {
        if(!$traceType){
            $traceType=new TraceType();
        }

        $form=$this->createForm(TraceTypeType::class,$traceType);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($traceType);
            $manager->flush();
            return $this->redirectToRoute("traceTypes");
        }
        return  $this->render('create.html.twig',[
            'title'=>"TraceType",
            'form'=>$form->createView(),
            'editMode'=>$traceType->getId() !==null
        ]);
    }
    /**
     * @Route("/delete/{id}", name="deleteTraceType")
     */
    public function delete_traceType(EntityManagerInterface $manager,TraceType $traceType)
    {
        $manager->remove($traceType);
        $manager->flush();
        return $this->redirectToRoute('traceTypes');
    }
}
