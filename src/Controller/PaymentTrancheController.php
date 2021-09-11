<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\PaymentTranche;
use App\Form\ActivityType;
use App\Form\PaymentTrancheType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PaymentTrancheController
 * @package App\Controller
 * @Route("paymentTranche")
 */
class PaymentTrancheController extends AbstractController
{
    /**
     * @Route("/paymentTranches", name="paymentTranches")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $paymentTranches=$manager->getRepository(PaymentTranche::class)->findAll();
        return $this->render('payment_tranche/paymentTranches.html.twig', [
          'paymentTranches'=> $paymentTranches
        ]);
    }
 /**
 * @Route("/create", name="createPaymentTranche")
 * @Route("/update/{id}", name="updatePaymentTranche")
 */
    public function handle_activity(Request $request,EntityManagerInterface $manager,PaymentTranche $PaymentTranche= null)
    {
        if(!$PaymentTranche){
            $PaymentTranche=new PaymentTranche();
        }

        $form=$this->createForm(PaymentTrancheType::class,$PaymentTranche);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($PaymentTranche);
            $manager->flush();
            return $this->redirectToRoute("paymentTranches");
        }
        return  $this->render('create.html.twig',[
            'title'=>"PaymentTranche",
            'form'=>$form->createView(),
            'editMode'=>$PaymentTranche->getId() !==null
        ]);
    }
    /**
     * @Route("/delete/{id}", name="deletePaymentTranche")
     */
    public function delete_activity(EntityManagerInterface $manager,PaymentTranche $paymentTranche)
    {
        $manager->remove($paymentTranche);
        $manager->flush();
        return $this->redirectToRoute('paymentTranches');
    }
}
