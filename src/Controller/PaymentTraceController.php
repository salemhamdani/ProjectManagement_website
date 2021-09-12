<?php

namespace App\Controller;

use App\Entity\PaymentTrace;
use App\Form\PaymentTraceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class PaymentTraceController
 * @package App\Controller
 * @Route("paymentTrace")
 */
class PaymentTraceController extends AbstractController
{
    /**
     * @Route("/paymentTraces", name="paymentTraces")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $paymentTraces=$manager->getRepository(PaymentTrace::class)->findAll();
        return $this->render('payment_trace/paymentTraces.html.twig', [
            'paymentTraces'=>$paymentTraces
        ]);
    }
    /**
     * @Route("/create", name="createPaymentTrace")
     * @Route("/update/{id}", name="updatePaymentTrace")
     */
    public function handle_activity(Request $request,EntityManagerInterface $manager,PaymentTrace $paymentTrace= null)
    {
        if(!$paymentTrace){
            $paymentTrace=new PaymentTrace();
        }else {
            $paymentTrace->setFile(new File($this->getParameter('traces_directory').'/'.$paymentTrace->getFile()));
        }

        $form=$this->createForm(PaymentTraceType::class,$paymentTrace);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $file=$form->get('file')->getData();
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('traces_directory'),  $newFilename );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $paymentTrace->setFile($newFilename);

            $manager->persist($paymentTrace);
            $manager->flush();
            return $this->redirectToRoute("paymentTraces");
        }
        return  $this->render('create.html.twig',[
            'title'=>"PaymentTrace",
            'form'=>$form->createView(),
            'editMode'=>$paymentTrace->getId() !==null
        ]);
    }
    /**
     * @Route("/delete/{id}", name="deletePaymentTrace")
     */
    public function delete_paymentTrace(EntityManagerInterface $manager,PaymentTrace $paymentTrace)
    {
        $manager->remove($paymentTrace);
        $manager->flush();
        return $this->redirectToRoute('paymentTraces');
    }
}
