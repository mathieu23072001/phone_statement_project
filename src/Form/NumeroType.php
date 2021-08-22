<?php

namespace App\Form;


use App\Form\CasType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class NumeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('numero', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'numero de la personne'),
            'mapped'=> false
        ))
        
        ->add('cas', CollectionType::class, array(
            'entry_type'=> CasType::class,
            'label'=> 'cas contacts', 
            'entry_options'=> ['label'=>false],
            'allow_add'=> true,
            'allow_delete'=> true,
            'by_reference'=> false,
            'mapped'=> false
        ))
        
        


        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
         
        ]);
    }
}
