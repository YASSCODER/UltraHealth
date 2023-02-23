<?php

namespace App\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class StringToFileTransformer implements DataTransformerInterface
{
    private $targetDirectory;
    
    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }
    
    public function transform($value)
    {
        // Transform the value to display in the form field (not used in this example)
        return null;
    }

    public function reverseTransform($value)
{
    if (!$value) {
        return null;
    }
    
    $fileName = pathinfo($value, PATHINFO_FILENAME);
    $fileExtension = pathinfo($value, PATHINFO_EXTENSION);
    $newFileName = $fileName.'-'.uniqid().'.'.$fileExtension;
    
    $file = new File($value);
    
    try {
        $file->move($this->targetDirectory, $newFileName);
    } catch (FileException $e) {
        // Handle the exception if the file cannot be moved
    }
    
    return new File($this->targetDirectory.'/'.$newFileName);
}
}