<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'attr'=>['placeholder'=>'Enter Client Name'
                ]])
            ->add('email',EmailType::class,[
                'attr'=>['placeholder'=>'Enter Client email'
                ], 'required' => true
            ])
            ->add('address',TextType::class,[
                'attr'=>['placeholder'=>'Enter Client Address'
                ]])
            ->add('phone',IntegerType::class,[
                'attr'=>['placeholder'=>'Enter Client phone number'
                ], 'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
