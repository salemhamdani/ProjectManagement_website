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
     * @Route("/client", name="client")
     */
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
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
     * @Route ("client/add_client",name="add_client")
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
        return $this->render('client/add_client.html.twig',[
            'form'=>$form->createView(),
            'editMode'=>$client->getId()!==null,
            'title'=>"Adding Client"
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


    /**
     * @Route ("client/client/{id}",name="update_client")
     */
    public function handel_client(Client $client):Response
    {   $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $users=$client->getUsers();
        return $this->render('client/update_client.html.twig   ',[
            'client'=>$client,
            'users'=>$users
        ]);
    }

    /**
     * @Route ("client/modify/{id}",name="modify_client")
     */
    public function modify_client(Client $client,EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder):Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $client->setName($_POST['name']);
        $client->setEmail($_POST['email']);
        $client->setAddress($_POST['address']);
        $client->setPhone($_POST['phone']);
        $manager->persist($client);
        $manager->flush();
        return $this->redirectToRoute("clients");
    }
}
