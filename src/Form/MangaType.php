<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Manga;
use App\Entity\Types;
use App\Entity\Mangaka;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('original_name', TextType::class)
            ->add('synopsis', TextType::class)
            ->add('thumbnail', TextType::class, [
                'required' => false, //  pas obligatoire de modifier l'image
            ])
            // permet de sélectionner un type de manga parmi ceux existants
            ->add('genre', EntityType::class, [
                'multiple' => true,
            ])
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'multiple' => true,
                'choice_label' => 'name',
            ])
            ->add('typeManga', EntityType::class, [
                'class' => Types::class,
                'choice_label' => 'name',
            ])
            //permet de sélectionner le ou les mangaka
            ->add('mangakas', EntityType::class, [
                'class' => Mangaka::class,
                'multiple' => true,
                'choice_label' => 'name',
            ])
            ->add('thumbnailFile', FileType::class, [
                'required' => false,
                'attr' => ['readonly' => true], // Pour éviter les modifications manuelles
            ])
            ->add('release_date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('number_pages', NumberType::class, [
                'required' => true,
            ])
            ->add('slug', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Confirmer']);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manga::class,
        ]);
    }
}
