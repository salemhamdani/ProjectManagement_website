<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/user/users",name="users")
     */
    public function read_users(EntityManagerInterface $manager):Response
    {  $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $users=$manager->getRepository(User::class)->findAll();
        return $this->render('user/users_table.html.twig',[
            "users"=>$users
        ]);
    }
    /**
     * @Route ("user/delete/{id}",name="delete_user")
     */
    public function remove_user(User $user,EntityManagerInterface $manager)
    { $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $manager->remove($user);
        $manager->flush();
        $this->addFlash('success', 'User deleted !');
        return $this->redirectToRoute('users');
    }
    /**
     * @Route ("user/update/{id}",name="update_user")
     */
    public function handel_user(User $user):Response
    {    $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('user/update_user.html.twig   ',[
            'user'=>$user
        ]);
    }
    /**
     * @Route ("user/modify/{id}",name="modify_user")
     */
    public function modify_user(User $user,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder):Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($_POST['submit']=="info"){
            $user->setName($_POST['name']);
            $user->setEmail($_POST['email']);
            $user->setAddress($_POST['address']);
            $user->setRole($_POST['role']);
            if(strcmp($user->getRole(), 'USER')===0){
                $user->setRoles(json_encode(['ROLE_USER']));
            }else{
                $user->setRoles(json_encode(['ROLE_ADMIN']));
            }
        }else{
            $hash=  $encoder->encodePassword($user, $_POST['password']);
            $user->setPassword($hash);
        }
        $manager->persist($user);
        $manager->flush();
        $this->addFlash('success', 'User updated !');
        return $this->redirectToRoute("users");
    }
    /**
     * @Route ("user/add",name="add_user")
     */
    public function create_user(Request $request,EntityManagerInterface  $manager,UserPasswordEncoderInterface $encoder){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user=new User();
        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $hash=  $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            if(strcmp($user->getRole(), 'USER')===0){
                $user->setRoles(json_encode(['ROLE_USER']));
            }else{
                $user->setRoles(json_encode(['ROLE_ADMIN']));
            }
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Operation created !');
            return $this->redirectToRoute('users');
        }
        return $this->render('user/add_user.html.twig',[
            'form'=>$form->createView(),
            'title'=>"Adding User"
        ]);
    }

}
