<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType ;
use Symfony\Component\Form\Extension\Core\Type\FileType ;
use Symfony\Component\Form\Extension\Core\Type\DateType ;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre' ,TextType::class , [
                'attr' => [
                    'placeholder' => 'Titre',
                    'class' => 'form-control form-control-rounded'
                ]
            ])
            ->add('nbPages' ,TextType::class , [
                'attr' => [
                    'placeholder' => 'Nombre de page',
                    'class' => 'form-control form-control-rounded'
                ]
            ])
            ->add('dateEdition', DateType::class, [
                'widget' => 'single_text', // Enables the HTML5 date picker
                'html5' => true,
                'attr' => [
                    'class' => 'form-control form-control-rounded',
                ],
                'input' => 'datetime', // Stores the input as a \DateTime object
                'format' => 'yyyy-MM-dd', // Defines the date format
                'years' => range(1900, date('Y')), // Allows dates from 1900 to the current year
            ])
            ->add('nbExemplaire' ,TextType::class , [
                'attr' => [
                    'placeholder' => 'Nombre des Exemplaires',
                    'class' => 'form-control form-control-rounded'
                ]
            ])
            ->add('prix' ,TextType::class , [
                'attr' => [
                    'placeholder' => 'Prix',
                    'class' => 'form-control form-control-rounded'
                ]
            ]) 
            ->add('description' ,TextType::class , [
                'attr' => [
                    'placeholder' => 'Description',
                    'class' => 'form-control form-control-rounded'
                ]
            ]) 
            ->add('isbn' ,TextType::class , [
                'attr' => [
                    'placeholder' => 'isbn',
                    'value' => rand(10000000,999989999),
                    'class' => 'form-control form-control-rounded'
                ]
            ])
            ->add('imageFile', FileType::class,[
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-rounded'
                ]
            ])
            ->add('editeur', EntityType::class, [
                'class' => Editeur::class,
                'attr' => [
                    'class' => 'form-control form-control-rounded'
                ]
            ])
            ->add('auteur', EntityType::class, [
                
                'attr' => [
                    'class' => 'form-control overselect'
                ],
                // looks for choices from this entity
                'class' => Auteur::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'nom',
            
                // used to render a select box, check boxes or radios
                'multiple' => true,
                // 'expanded' => true,
                

            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'attr' => [
                    'class' => 'form-control form-control-rounded'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
