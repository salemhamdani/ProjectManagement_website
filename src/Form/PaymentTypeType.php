<?php

namespace App\Form;

use App\Entity\PaymentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'attr'=>['placeholder'=>'Enter The Name '
                ],'required' => true])
            ->add('limitation',NumberType::class,[
                'attr'=>['placeholder'=>'Enter The Value Of The Limitation'
                ],'required' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PaymentType::class,
        ]);
    }
}
