<?php

namespace App\Controller;

use App\Entity\Authors;
use App\Entity\Books;
use App\Entity\Relations;
use App\Form\BookType;
use App\Service\ImageService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/changeDB", name="lib_change")
     */
    public function change(EntityManagerInterface $entityManager){
        $book_repo = $entityManager->getRepository(Books::class)->findAll();
        for ($i = 0; $i < count($book_repo); $i++){
            $book_repo[$i]->setImage('img'.rand(1, 10).'.jpg');

            $entityManager->persist($book_repo[$i]);
            $entityManager->flush();
        }

        dd($book_repo);
    }

//your relations is stupid. create table just holding book and author id. without relation.

    /**
     * @Route("/delete", name="lib_delete")
     */
    public function delete(EntityManagerInterface $entityManager)
    {
        $book_repo = $entityManager->getRepository(Books::class)->findAll();
        for ($i = 0; $i < count($book_repo); $i++) {

            $entityManager->remove($book_repo[$i]);
            $entityManager->flush();
        }

        $author_repo = $entityManager->getRepository(Authors::class)->findAll();
        for ($i = 0; $i < count($author_repo); $i++) {

            $entityManager->remove($author_repo[$i]);
            $entityManager->flush();
        }

        dd($book_repo, $author_repo);
    }


    //Больше двух соавторов или от двух соавторов?
    /**
     * @Route ("/query", name="lib_query")
     */
    public function query(EntityManagerInterface $entityManager){
        $repository = $entityManager->getRepository(Books::class)->findAll();
        $titles = [];
        for ($i = 0; $i < count($repository); $i++) {
            if($repository[$i]->getARelations()->count() > 2) {
                array_push($titles, [$repository[$i]->getTitle()]);
            }
        }
        dd($titles);


        //SQL Query

//SELECT title FROM root.books WHERE root.books.id IN
//(SELECT books_id FROM root.books_authors
//GROUP BY books_id HAVING COUNT(books_id) > 2);

    }
}