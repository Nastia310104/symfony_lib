<?php

namespace App\Service;

use App\Entity\Books;
use Doctrine\ORM\EntityManagerInterface;

interface BookServiceInterface
{
    /**
     * @param EntityManagerInterface $em
     * @param $book
     * @return bool
     */
    public function isBookExist(EntityManagerInterface $em, Books $book):bool;

    public function addBookInDatabase();


}