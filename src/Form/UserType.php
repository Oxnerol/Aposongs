<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserRole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('isVerified', CheckboxType::Class, [
                'label' => 'This account is verified',
                'required' => true,
            ])
            ->add('userRole', EntityType::class,[
                'class' => UserRole::class,
                'choice_label' => 'name',
                'mapped' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Valider'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
