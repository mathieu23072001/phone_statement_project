<?php

namespace App\Form;

use App\Form\CasType;
use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
        ->add('contact', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'numero de la personne'),
            
            
        ))
           
            
->add('cas', CollectionType::class,[
    'entry_type'=> CasType::class,
    'entry_options'=> ['label'=>false],
    'allow_add'=> true,
    'allow_delete'=> true,
    'by_reference'=> false,


    
])

        
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
