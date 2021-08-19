<?php

namespace App\Form;

use App\Entity\Personne;
use App\Form\UserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class registerNomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
      
        ->add('numero', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'numero de la personne')
        ))

        ->add('nom', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'nom de la personne')
        ))

            


           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
