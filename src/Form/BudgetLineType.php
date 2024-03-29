<?php

namespace App\Form;

use App\Entity\BudgetLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BudgetLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
        'attr'=>['placeholder'=>'Enter BudgetLine Name'
        ],'required' => true])
            ->add('percentage',NumberType::class,[
                'attr'=>['placeholder'=>'Enter the percentage '
                ],'required' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BudgetLine::class,
        ]);
    }
}
