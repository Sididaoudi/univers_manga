<?php

namespace App\Form;

use App\Entity\Mangaka;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MangakaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('biography')
            ->add('birthDate', null, [
                'widget' => 'single_text',
            ])
            ->add('deathDate', null, [
                'widget' => 'single_text',
            ])
            ->add('thumbnail')
            ->add('slug', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Confirmer']);;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mangaka::class,
        ]);
    }
}
