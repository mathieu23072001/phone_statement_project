<?php

namespace App\Form;

use App\Entity\CDS;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;





class CdsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('nom', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'votre nom')
        ))


        ->add('quartier', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'quartier du centre')
        ))

        ->add('longitude', NumberType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'coordonnée geographique')
        ))


        ->add('latitude', NumberType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'coordonnée geographique')
        ))


        ->add('color', ColorType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'couleur')
        ))


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CDS::class,
        ]);
    }
}
