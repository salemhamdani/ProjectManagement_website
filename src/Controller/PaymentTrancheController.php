<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\PaymentTranche;
use App\Form\ActivityType;
use App\Form\PaymentTrancheType;
use App\Service\Validator;
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
    public function handle_paymentTranche(Request $request,EntityManagerInterface $manager,PaymentTranche $PaymentTranche= null, Validator $validator)
    {
        $message='PaymentTranche updated !';
        if(!$PaymentTranche){
            $PaymentTranche=new PaymentTranche();
            $message='PaymentTranche created !';
        }
        $test=$PaymentTranche->getId() !==null;
        $form=$this->createForm(PaymentTrancheType::class,$PaymentTranche);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($PaymentTranche);
            if ($validator->validatePaymentTranche($PaymentTranche))
            {
                $manager->flush();
                $this->addFlash('success', $message);
                return $this->redirectToRoute("paymentTranches");
            }else {
                $this->addFlash('error','the value of paymentTranche given exceeded the unpaid amount of operation !');
                if ($test)
                {
                    return $this->redirectToRoute('updatePaymentTranche',['id'=>$PaymentTranche->getId()]);
                }
                else
                {
                    return $this->redirectToRoute('createPaymentTranche');
                }
            }


        }
        return  $this->render('create.html.twig',[
            'title'=>"PaymentTranche",
            'form'=>$form->createView(),
            'editMode'=>$test
        ]);
    }
    /**
     * @Route("/delete/{id}", name="deletePaymentTranche")
     */
    public function delete_paymentTranche(EntityManagerInterface $manager,PaymentTranche $paymentTranche)
    {
        $manager->remove($paymentTranche);
        $manager->flush();
        $this->addFlash('success', 'PaymentTranche deleted !');
        return $this->redirectToRoute('paymentTranches');
    }
}
