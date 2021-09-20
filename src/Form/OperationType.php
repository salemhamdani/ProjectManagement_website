<?php

namespace App\Form;

use App\Entity\Operation;
use App\Entity\PaymentTranche;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'attr'=>['placeholder'=>'Enter The Operation Name'
                ],'required' => true])
            ->add('date',DateTimeType::class,[
                'widget' => 'single_text','required' => true])
            ->add('price',NumberType::class,[
                'attr'=>['placeholder'=>'Enter The Price'
                ],'required' => true])
            ->add('description',TextType::class,[
                'attr'=>['placeholder'=>'Enter The description '
                ]])
            ->add('activity')
            ->add('budgetLine')
            ->add('paymentTranche',CollectionType::class ,[
                'entry_type'=>PaymentTrancheType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
