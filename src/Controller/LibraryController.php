<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function home(){
        return $this->render('home.html.twig', [
            'title' => 'Home',
        ]);
    }

    /**
     * @Route("/books")
     */
    public function books(){
        $years = ['13', '14', '15'];
        $filters = ['Name', 'Author', 'Year'];
        $option = 'foo'; //get from filters leter
        return $this->render('books.html.twig', [
            'title' => 'Books',
            'filters' => $filters,
            'years' => $years,
            'option' => $option
        ]);
    }

//    /**
//     * @Route ("/authors")
//     */
}