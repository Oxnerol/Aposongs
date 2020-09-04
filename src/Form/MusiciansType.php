<?php

namespace App\Form;

use App\Entity\Musicians;
use App\Entity\ContributionLanguage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MusiciansType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {       
        $messaheImg = 'Choisir une image';
        $require = true;

        if($builder->getData()->getMusicianImg() != null)
        {
            $messaheImg ='Changer l\'image';
            $require = false;
        }

        $builder
            ->add('firstName', TextType::Class, [
                'label' => 'Prénom ou surnom *',
                'required' => true,
            ])
            ->add('lastName', TextType::Class, [
                'label' => 'Nom de famille',
                'required' => false,
            ])
            ->add('nickname', TextType::Class, [
                'label' => 'Surnom',
                'required' => false,
            ])
            ->add('born', DateType::class,[
                'label' => 'Née le',
                'years' => range(date('Y'), '1920'),
                'required' => false,
                'placeholder' => [
                    'year' => 'Annee',
                    'month' => 'Mois',
                    'day' => 'Jour',
                ]

            ])
            ->add('death', DateType::class,[
                'label' => 'Mort le',
                'years' => range(date('Y'), '1920'),
                'required' => false,
                'placeholder' => [
                    'year' => 'Annee',
                    'month' => 'Mois',
                    'day' => 'Jour',
                ]

            ])
            ->add('musicianImg', FileType::Class,[
                'mapped' => false,
                'label' => 'Image *',
                'required' => $require,
                'attr' => ['placeholder' => $messaheImg],
                
            ])
            ->add('altImg', TextType::class,[
                'label' => 'Image description *',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Image description',]
            ])
            ->add('biography', TextareaType::class,[
                'required' => false,

            ])

            ->add('save', SubmitType::class, ['label' => 'Ajouter un Musicien'])
            ->add('save2', SubmitType::class, ['label' => 'Ajouter un Musicien'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Musicians::class,
        ]);
    }
}
