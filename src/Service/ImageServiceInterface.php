<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageServiceInterface
{
    /**
     * @param UploadedFile $file
     * @return string
     */
    public function ImageUpload(UploadedFile $file):string;

}