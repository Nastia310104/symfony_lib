<?php

namespace App\Admin;

use App\Entity\Authors;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class AdminBooks extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            //how to add file
//            ->with('Image', ['class' => 'col-md-2'])
//                ->add('image', FileType::class)
//            ->end()
            ->with('Book', ['class' => 'col-md-6'])
                ->add('title', TextType::class)
                ->add('description', TextType::class)
                ->add('Year', IntegerType::class)
            ->end()
            //nomap
            ->with('Author', ['class' => 'col-md-4'])
                ->add('author', ModelAutocompleteType::class, [
                    'multiple' => true,
                    'class' => Authors::class,
                    'property' => 'name',
                ])
            ->end()
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('title')
//            ->add('authors', null, [ //i don't know why "null" didn't work
//                'field_type' => EntityType::class,
//                'field_option' => [
//                    'class' => Authors::class,
//                    'choice_field' => 'name',
//                ],
//            ])
            ->add('year')
        ;
    }
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('image')
            ->addIdentifier('title')
            ->add('description')
            ->add('a_relations', null, [
                'associated_property' => 'name',
                'label' => 'Author',
            ])
            ->add('year')
            ;
    }
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            //how to add file
//            ->with('Image', ['class' => 'col-md-2'])
//                ->add('image', FileType::class)
//            ->end()
            ->with('Book', ['class' => 'col-md-6'])
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('Year', IntegerType::class)
            ->end()
            //nomap
            ->with('Author', ['class' => 'col-md-4'])
            ->add('author', ModelAutocompleteType::class, [
                'multiple' => true,
                'class' => Authors::class,
                'property' => 'name',
            ])
            ->end()
        ;
    }

    public function toString(object $object): string
    {
        return $object instanceof \App\Entity\Books
            ? $object->getTitle()
            : 'Author';
    }

}