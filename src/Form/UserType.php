<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         
        ->add('email', EmailType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'votre email')
        ))
        
        ->add('password', PasswordType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'votre mot de passe')
        ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
