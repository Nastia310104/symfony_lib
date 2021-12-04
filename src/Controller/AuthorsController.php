<?php

namespace App\Controller;

use App\Entity\Authors;
use App\Entity\Books;
use App\Form\AuthorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthorsController extends AbstractController
{

    /**
     * @Route("/authors", name="lib_authors")
     */
    public function authors(EntityManagerInterface  $entityManager,  Request $request){

        $author = new Authors();

        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

//            Check book
            $book_title = $form->get('book_title')->getData();
            $book = $entityManager->getRepository(Books::class)->findOneBy(['title' => $book_title]);
            if (!$book){
                $this->addFlash(
                    'error',
                    'Book does not exist'
                    //add link to create book
                );
                return $this->redirectToRoute('lib_authors');
            }

            //Check and add author
            $isAuthorExist = $entityManager->getRepository(Authors::class)->findOneBy(['name' => $author->getName()]);
            if (!$isAuthorExist) {
                $author->addBook($book)
                    ->setQuantity(1);

                $book->addARelations($author);
                $book->setAuthor($book->getAuthor().'.'.$author->getName());

                $entityManager->persist($author);
                $entityManager->flush();
            } else {
                $author->addBook($book)
                    ->setQuantity($author->getQuantity() + 0);

                $book->addARelations($author);
                $book->setAuthor($book->getAuthor().'.'.$author->getName());


                $entityManager->persist($author);
                $entityManager->flush();
            }
        }

        $repository = $entityManager->getRepository(Authors::class);
        $list = $repository->findAll();

        $filter = $request->request->get('filterRadio');
        $order = $request->request->get('orderRadio');
        $input = $request->request->get('filter_option');

        if($filter && $input){
            if($order){
                global $list;
                $list = $repository->findBy([$filter => $input], [$filter => $order]);
            }
            global $list;
            $list = $repository->findBy([$filter => $input]);

        } elseif ($order){
            global $list;
            $list = $repository->findBy([], [$order]);
        } elseif ((!$filter && $input) || ($filter && !$input)) {
            $this->addFlash(
                'error',
                'You forget choose filter or input'
            );
        }

        //inline form


        return $this->renderForm('authors.html.twig', [
            'title' => 'Authors',
            'list' => $list,
            'form' => $form,
        ]);
    }

}