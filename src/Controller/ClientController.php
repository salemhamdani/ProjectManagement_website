<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ClientController extends AbstractController
{
    /**
     * @Route("client/clients",name="clients")
     */
    public function read_clients(EntityManagerInterface $manager):Response
    {   $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $clients=$manager->getRepository(Client::class)->findAll();
        return $this->render('client/clients_table.html.twig',[
            "clients"=>$clients
        ]);
    }
    /**
     * @Route ("client/add_client",name="createClient")
     * @Route ("client/client/{id}",name="update_client")
     */
    public function create_client(Client $client=null,Request $request,EntityManagerInterface  $manager)
    {   $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if(!$client){
            $client=new Client();
        }
        $form=$this->createForm(ClientType::class,$client);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $manager->persist($client);
            $manager->flush();
            return $this->redirectToRoute('clients');
        }
        return $this->render('create.html.twig',[
            'form'=>$form->createView(),
            'editMode'=>$client->getId()!==null,
            'title'=>" Client"
        ]);
    }

    /**
     * @Route ("client/delete/{id}",name="delete_client")
     */
    public function remove_client(Client $client,EntityManagerInterface $manager)
    {   $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $manager->remove($client);
        $manager->flush();
        return $this->redirectToRoute('clients');

    }
}
