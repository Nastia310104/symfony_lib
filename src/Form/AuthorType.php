<?php

namespace App\Form;

use App\Entity\Authors;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AuthorType extends AbstractType
{

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => false,
                'attr' => [
                    'placeholder' => 'Name'
                ]
            ))
            ->add('book_title', null, array(
                'label' => false,
                'mapped' =>false,
                'attr' => [
                    'placeholder' => 'Book title',
                ]
            ))
            ->add('Save', SubmitType::class, [
                'label' => 'Add new author'
            ])
            //Не уверена, что это правильный листенер
            ->addEventListener(
                FormEvents::SUBMIT,
                [$this, 'updateQuantity']
            )
        ;
    }

    public function updateQuantity(FormEvent $event)
    {
        $author = $event->getData();
        $repo = $this->em->getRepository(Authors::class)->findOneBy(['name' => $author->getName()]);
        if ($repo) {
            $repo->setQuantity($repo->getQuantity() + 1);

            $this->em->persist($repo);
            $this->em->flush();
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Authors::class,
        ]);
    }
}
