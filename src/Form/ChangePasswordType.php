<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('oldPassword', PasswordType::Class, [
                'mapped' => false,
                'invalid_message' => 'Mauvais mot de passe',
                'label' =>'Votre mot de passe'
                
            ])
            ->add('newPassword', RepeatedType::Class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => true,
                'invalid_message' => 'Votre nouveau mot de passe n\'es pas identique.',
                'first_options'  => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Retapez votre mot de passe'],
                
            ])
            ->add('Valider', SubmitType::Class)
            ->add('clickBTN', HiddenType::Class,[
                'mapped' => false,

                    'attr' => ['id' => '']]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
