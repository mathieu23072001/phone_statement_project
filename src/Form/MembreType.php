<?php

namespace App\Form;

use App\Entity\Membre;
use App\Form\UserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
      
        ->add('nom', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'votre nom')
        ))

        ->add('prenoms', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'votre prenoms')
        ))

            ->add('user', UserType::class)


            ->add('role', ChoiceType::class, [
                'required'=>true,
                'mapped'=> false,
                'choices'  => [
                    'agent de sante' => 'agent de sante',
                    'responsable de centre' => 'responsable de centre',
                 
                  
                ],
                'attr'=>array('class'=>'form-control','placeholder'=>'sexe'),
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
