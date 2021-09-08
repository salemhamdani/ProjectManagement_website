<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'attr'=>['placeholder'=>'Enter Name'
                ]])
            ->add('email',EmailType::class,[
                'attr'=>['placeholder'=>'Enter your email'
                ], 'required' => true
            ])
            ->add('password',PasswordType::class,[
                'attr'=>['placeholder'=>'Enter your password'
                ], 'required' => true
            ])
            ->add('confirm_password',PasswordType::class,[
                'attr'=>['placeholder'=>'Renter your password'
                ], 'required' => true,'label'=>'Confirm password'
            ])
            ->add('address',TextType::class,[
                'attr'=>['placeholder'=>'Enter your Address'
                ]])
           ->add('role',ChoiceType::class,[
                'choices'  => [
                    'Roles'=>[
                            'User' => 'USER',
                            'Admin' => 'ADMIN',
                    ]

                ],'required' => true
            ])
            ->add('client')
            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-secondary'
                ],'label'=>'Create Account'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
