<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Titre de la news',
                'required' => true,
            ])
            ->add('textField', TextareaType::class,[
                'label' => 'Texte de la news',
                'attr' => ['cols' => '5', 'rows' => '10'],
                'required' => true,

            ])
            ->add('save', SubmitType::class, ['label' => 'Envoyer la news'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
