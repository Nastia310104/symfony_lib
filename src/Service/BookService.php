<?php

namespace App\Service;

use App\Entity\Books;
use Doctrine\ORM\EntityManagerInterface;

class BookService implements BookServiceInterface
{
    public function isBookExist(EntityManagerInterface $em, Books $book): bool
    {
        $repository = $em->getRepository(Books::class)->findOneBy([$book->getTitle()]);

        if (!$repository) return false;
        else return true;
    }

    public function addBookInDatabase()
    {

    }
}