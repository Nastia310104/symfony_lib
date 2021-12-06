<?php

namespace App\Admin;

use App\Entity\Books;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class AuthorsAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('Author', ['class' => 'col-md-6'])
                ->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
                ->add('quantity', IntegerType::class)
            ->end()
            ->with('Relation to', ['class' => 'col-md-6'])
                ->add('books', ModelType::class, [
                    'multiple' => true,
                    'class' => Books::class,
                    'property' => 'title',
                ])
            ->end()
            ;
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper->add('name');
        $datagridMapper->add('quantity');
    }
    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('name')
            ->add('quantity')
            ->add('books', null, [
                'associated_property' => 'title'
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('name');
        $show->add('quantity');
    }

    public function toString(object $object): string
    {
        return $object instanceof \App\Entity\Authors
            ? $object->getName()
            : 'Author';
    }
}