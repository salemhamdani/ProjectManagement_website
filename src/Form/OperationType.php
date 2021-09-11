<?php

namespace App\Form;

use App\Entity\Operation;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'attr'=>['placeholder'=>'Enter The Operation Name'
                ],'required' => true])
            ->add('date',TextType::class,[
        'attr'=>['placeholder'=> 'Enter the Date '],'required' => true])
            ->add('price',NumberType::class,[
                'attr'=>['placeholder'=>'Enter The Price'
                ],'required' => true])
            ->add('description',TextType::class,[
                'attr'=>['placeholder'=>'Enter The description '
                ]])
            ->add('activity')
            ->add('budgetLine')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
