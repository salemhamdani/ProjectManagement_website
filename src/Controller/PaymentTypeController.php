<?php

namespace App\Controller;

use App\Entity\BudgetLine;
use App\Entity\PaymentType;
use App\Entity\Project;
use App\Form\BudgetLineType;
use App\Form\PaymentTypeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PaymentTypeController
 * @package App\Controller
 * @Route("paymentType")
 */
class PaymentTypeController extends AbstractController
{
    /**
     * @Route("/paymentTypes", name="paymentTypes")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $paymentTypes=$manager->getRepository(PaymentType::class)->findAll();
        return $this->render('payment_type/paymentTypes.html.twig', [
            'paymentTypes'=>$paymentTypes
        ]);
    }
    /**
     * @Route("/create", name="createPaymentType")
     * @Route("/update/{id}", name="updatePaymentType")
     */
    public function handle_paymentType(Request $request,EntityManagerInterface $manager,PaymentType $paymentType= null)
    {
        if(!$paymentType){
            $paymentType=new PaymentType();
        }
        $form=$this->createForm(PaymentTypeType::class,$paymentType);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $manager->persist($paymentType);
            $manager->flush();
            return $this->redirectToRoute("paymentTypes");
        }
        return  $this->render('create.html.twig',[
            'title'=>"PaymentType",
            'form'=>$form->createView(),
            'editMode'=>$paymentType->getId() !==null
        ]);
    }
    /**
     * @Route("/delete/{id}", name="deletePaymentType")
     */
    public function delete_paymentType(EntityManagerInterface $manager,PaymentType $paymentType)
    {
        $manager->remove($paymentType);
        $manager->flush();
        return $this->redirectToRoute('paymentTypes');
    }

}
