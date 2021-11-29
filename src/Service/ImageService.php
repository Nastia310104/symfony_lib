<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService implements ImageServiceInterface
{
    private $postImageDirectory;

    public function __construct($postImageDirectory)
    {
        $this->postImageDirectory = $postImageDirectory;
    }

    /**
     * @return mixed
     */
    public function getPostImageDirectory()
    {
        return $this->postImageDirectory;
    }

    public function ImageUpload(UploadedFile $file): string
    {
        $filename = uniqid().'.jpg';

        try {
            $file->move($this->getPostImageDirectory(), $filename);
        } catch (FileException $exception) {
            return $exception;
        }

        return $filename;
    }



}

