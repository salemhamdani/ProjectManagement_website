<?php

namespace App\Form;

use App\Entity\PaymentTranche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentTrancheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value',NumberType::class,[
                'attr'=>['placeholder'=>'Enter The Value Of The Tranche'
                ],'required' => true])
            ->add('operation')
            ->add('paymentType')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PaymentTranche::class,
        ]);
    }
}
