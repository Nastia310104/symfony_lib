<?php

namespace App\Controller;

use App\Entity\Books;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{
    /**
     * @Route("/", name="lib_home")
     */
    public function home(){
        return $this->render('home.html.twig', [
            'title' => 'Home',
        ]);
    }

    /**
     * @Route("/books", name="lib_books")
     */
    public function books(EntityManagerInterface $entityManager){

        $filter = '1839';
        $repository = $entityManager->getRepository(Books::class);
        $library = $repository->findByYearAndDESC( $filter);


        $filters = ['Name', 'Author', 'Year'];
        $option = 'foo'; //get from filters leter
        return $this->render('books.html.twig', [
            'title' => 'Books',
            'filters' => $filters,
            'option' => $option,
            'library' => $library
        ]);
    }

    /**
     * @Route ("/authors", name="lib_authors")
     */
    public function authors(){
        return $this->render('authors.html.twig', [
            'title' => 'Authors'
        ]);
    }

    /**
     * @Route("/new_book", name="lib_new_b")
     */
    public function add_new_book(EntityManagerInterface $entityManager){
//        $book = new Books();
//        $book->setBName('The Adventures of Oliver Twist')
//            ->setAuthor('Charles Dickens')
//            ->setYear('1839')
//            ->setImage('/public/images/no_image.jpg')
//            ->setDescription(<<<EOF
//
//            Dickens’ second novel,
//            the book was originally published as a serial, in monthly
//            instalments that began in February 1837 and continued until
//            April 1839.
//
//            Oliver Twist is the first novel in the English language
//            to centre throughout on a child protagonist and is also
//            notable for Dickens’ unromantic portrayal of criminals and
//            their sordid lives.
//
//            A mysterious pregnant woman is found lying in the street,
//            and dies a few moments after giving birth to a son. The boy,
//            Oliver Twist lives a life of poverty and misfortune in a workhouse.
//            At the age of Nine, he escapes from the workhouse, only
//            to find that greater dangers lurk outside.
//
//EOF
//            );
//
//        $entityManager->persist($book);
//        $entityManager->flush();
//
//        return new Response(sprintf(
//            'Your data is: id = #%d, name = %s, author = %s,
//            description = %s, year = %d',
//            $book->getId(),
//            $book->getBName(),
//            $book->getAuthor(),
//            $book->getDescription(),
//            $book->getYear(),
//        ));
        return $this->render('addNew.html.twig', [
            'title' => 'Add new book'
        ]);
    }
}