<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    const SITE = 'http://localhost:8000';

    const IMG_PATH = self::SITE . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR;

    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = self::IMG_PATH . md5(uniqid()) . '.' . $file->guessExtension();
        $file->move($this->getTargetDirectory(), $fileName);

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}