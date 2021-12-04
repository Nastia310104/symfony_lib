<?php

namespace App\Form;

use App\Entity\Books;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, array(
                'label' => false,
                'required' => false,
                'mapped' => false,
                ))
            ->add('title', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'label' => false,
                'attr' => [
                    'placeholder' => 'Title'
                ]
            ))
            ->add('author', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'label' => false,
                'attr' => [
                    'placeholder' => 'Author'
                ]
            ))
            ->add('description', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description'
                ]
            ))
            ->add('year', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'label' => false,
                'attr' => [
                    'placeholder' => 'Year'
                ]
            ))
            ->add('Save', SubmitType::class, [
                'label' => 'Add new book'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }

}
