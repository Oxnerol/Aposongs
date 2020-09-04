<?php

namespace App\Form;

use App\Entity\Genre;
use App\Form\LinkType;
use App\Entity\Artists;
use App\Entity\SubGenre;
use App\Entity\ContributionLanguage;
use Symfony\Component\Form\FormEvent;
use App\Form\ContributionLanguageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $boolImg = true;
        $messaheImg = 'Choisir une image';

        if($builder->getData()->getlogoImg() != null)
        {
            $boolImg = false;
            $messaheImg ='Changer d\'image';
        }
        $builder

            ->add('name', TextType::Class, [
                'label' => 'Nom de l\'artsite *',
                'required' => true,
            ])
            ->add('bandActivityStart', IntegerType::class,[
                'label' => 'Années début actives *',               
                'required' => true,
                

            ])
            ->add('bandActivityEnd', IntegerType::class,[
                'label' => 'Années de fin actives',  
                'required' => false,


            ])
            ->add('logoImg', FileType::Class,[
                'mapped' => false,
                'label' => 'Image *',
                'required' => $boolImg,
                'attr' => ['placeholder' => $messaheImg],
                
            ])
            ->add('altImg', TextType::class,[
                'label' => 'Image description *',
                'required' => true,

            ])
            ->add('biography', TextareaType::class,[
                'required' => false,

            ])


/*             ->add('genre', EntityType::class,[
                'class' => Genre::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true
            ])

            ->add('subGenre', EntityType::class,[
                'class' => SubGenre::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true
            ])

            ->add('link', CollectionType::class, [
                'entry_type' => LinkType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,

            ]) */

            ->add('save', SubmitType::class, ['label' => 'Ajouter un artist'])
            ->add('save2', SubmitType::class, ['label' => 'Ajouter un artist'])
        ;
        

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artists::class,
        ]);
    }
}
