<?php

namespace App\Controller;

use App\Entity\Authors;
use App\Entity\Books;
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
     * @Route("/books", name="lib_books")
     */
    public function books(EntityManagerInterface $entityManager, Request $request){

        $filter = $request->request->get('filterRadio');
        $order = $request->request->get('orderRadio');
        $input = $request->request->get('filter_option');

        $error = "";

        $repository = $entityManager->getRepository(Books::class);
        $library = $repository->findAll();

        if($filter && $input){
            if($order){
                global $library;
                $library = $repository->findBy([$filter => $input], [$order]);
            }
            $library = $repository->findBy([$filter => $input]);
        }

        $filters = ['name', 'author', 'year'];
        return $this->render('books.html.twig', [
            'title' => 'Books',
            'filters' => $filters,
            'library' => $library,
            'error' => $error
        ]);
    }

    /**
     * @Route ("/authors", name="lib_authors")
     */
    public function authors(EntityManagerInterface  $entityManager){

        $repository = $entityManager->getRepository(Authors::class);
        $list = $repository->findAll();

        return $this->render('authors.html.twig', [
            'title' => 'Authors',
            'list' => $list
        ]);
    }

//    /**
//     * @Route("/new_book", name="lib_new_b")
//     */
//    public function add_new_book(EntityManagerInterface $entityManager){
////        $book = new Books();
////        $book->setBName('The Adventures of Oliver Twist')
////            ->setAuthor('Charles Dickens')
////            ->setYear('1839')
////            ->setImage('/public/images/no_image.jpg')
////            ->setDescription(<<<EOF
////
////            Dickens’ second novel,
////            the book was originally published as a serial, in monthly
////            instalments that began in February 1837 and continued until
////            April 1839.
////
////            Oliver Twist is the first novel in the English language
////            to centre throughout on a child protagonist and is also
////            notable for Dickens’ unromantic portrayal of criminals and
////            their sordid lives.
////
////            A mysterious pregnant woman is found lying in the street,
////            and dies a few moments after giving birth to a son. The boy,
////            Oliver Twist lives a life of poverty and misfortune in a workhouse.
////            At the age of Nine, he escapes from the workhouse, only
////            to find that greater dangers lurk outside.
////
////EOF
////            );
////
////        $entityManager->persist($book);
////        $entityManager->flush();
////
////        return new Response(sprintf(
////            'Your data is: id = #%d, name = %s, author = %s,
////            description = %s, year = %d',
////            $book->getId(),
////            $book->getBName(),
////            $book->getAuthor(),
////            $book->getDescription(),
////            $book->getYear(),
////        ));
//
//
//
//        return $this->render('addNew.html.twig', [
//            'title' => 'Add new book'
//        ]);
//    }

    /**
     * @Route ("/books/add_new", name="lib_add_new", methods="POST")
     */
    public  function book_added(EntityManagerInterface $entityManager, Request $request)
    {
        $image = $request->request->get('image');
        $book_name = $request->request->get('b_name');
        $author_name = $request->request->get('a_name');
        $description = $request->request->get('description');
        $year = $request->request->get('year');


        $error = "";
        if(!$book_name || !$author_name || !$description || !$year){
            $error = 'You should fill all field';
        }

        $book = new Books();
        $author = new Authors();

        if ($image != ""){
            $book->setImage($image);
        }
        $book->setBName($book_name)
            ->setAuthor($author_name)
            ->setDescription($description)
            ->setYear($year);

//        $id = $entityManager->getRepository(Authors::class)->findBy(['name' => $author_name])[0];

//        $doctrine_author = $entityManager->getRepository(Authors::class)->find($id);
//        if ($doctrine_author){
//            $doctrine_author->setBookName($doctrine_author->getBookName().(',').$book_name)
//                ->setQuantity($doctrine_author->getQuantity() + 1);
//        }
//        else {
            $author->setName($author_name)
                ->setBookName($book_name)
                ->setQuantity(1);
//        }

        $entityManager->persist($book);
        $entityManager->persist($author);
        $entityManager->flush();

        return $this->redirectToRoute('lib_books', [
            'error' => $error
        ]);

    }

    /**
     * @Route ("/books/random_create", name="lib_rand")
     */
    public function rand_create(EntityManagerInterface  $entityManager){
        $a_names = ["Чулпан Тимофеева",
            "Кондрат Владимов", "Кира Котовская", "Пров Нехлюдов",
            "Тихон Незнанский","Эсмеральда Удачина"];
        $b_names = ["Китайская горькая тыква,Гибискус и Солянка",
            "Гордей и Огурцы бочковые на зиму в банках",
            "Редька,Шабрий и Окрошка на минералке",
            "Артишок Пров и Грузди соленые",
            "Родослав и Ряпушка по-карельски"];
        $desc = ["Инопланетянин звонить домой",
        "Миссис Робинсон, вы пытаетесь меня соблазнить, не так ли?",
            "Глядя на тебя, крошка",
        "Пристегните ремни. Будет жёсткая ночка
        ","Бог мне свидетель, — я никогда больше не буду голодать",
        "Валяй, порадуй меня!"];

        $year = rand(1800, 2021);

        $book = new Books();

        $book->setBName($b_names[rand(0, 4)])
            ->setAuthor($a_names[rand(0, 5)])
            ->setDescription($desc[rand(0, 5)])
            ->setYear($year);

        $entityManager->persist($book);
        $entityManager->flush();

        dd($book);


    }
}