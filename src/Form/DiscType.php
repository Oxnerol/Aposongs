<?php

namespace App\Form;

use App\Entity\Disc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class DiscType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $boolImg = true;
        $messaheImg = 'Choisir une image';

        if($builder->getData()->getcover() != null)
        {
            $boolImg = false;
            $messaheImg ='Changer l\'image';
        }

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du disque *',
                'required' => true,
            ])
            ->add('cover',FileType::Class,[
                'mapped' => false,
                'label' => 'Image',
                'required' => $boolImg,
                'attr' => ['placeholder' => $messaheImg],
            ])
            ->add('releaseDate', IntegerType::class,[
                'label' => 'Année sorti du disque *',
                'required' => true,
            ])
            ->add('altImg',TextType::class, [
                'label' => 'Description de l\'image *',
                'required' => true,
            ])
            ->add('save', SubmitType::Class, ['label' => 'Ajouter un disque'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Disc::class,
        ]);
    }
}
