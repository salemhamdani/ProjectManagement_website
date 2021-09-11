<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\ClientType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route ("/",name="homepage")
     */
    public function home(){
        return $this->redirectToRoute('home');
    }
    /**
     * @Route("/denied", name="denied")
     */
    public function denied():Response
    {
       return $this->render('security/access_denied.html.twig');
    }
    /**
     * @Route ("/signup_user",name="signup_user")
     */
    public function signup_client(Request $request,EntityManagerInterface  $manager,UserPasswordEncoderInterface $encoder)
    {
        $user=new User();
        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $hash=  $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $user->setRoles(json_encode(['ROLE_USER']));
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('login');
        }
        return $this->render('user/add_user.html.twig',[
            'form'=>$form->createView(),
            'editMode'=>$user->getId()!==null,
            'title'=>"Sign Up "
        ]);
    }

    /**
     * @Route ("/login",name="login")
     */
    public function login():Response
    {
        return $this->render('security/login.html.twig',[]);
    }
    /**
     * @Route ("/logout",name="logout")
     */
    public function logout():Response
    {

    }
}
