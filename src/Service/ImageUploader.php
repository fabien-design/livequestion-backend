<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

class ImageUploader
{
    public function __construct(private NamerInterface $namer, private PropertyMapping $propertyMapping) {}

    public function uploadImage(UploadedFile $file): string
    {
        // Générer le nom du fichier
        $fileName = $this->namer->name($file, $this->propertyMapping);

        // Déplacer le fichier vers le répertoire de destination
        $file->move($this->propertyMapping->getUploadDestination(), $fileName);

        return $fileName;
    }
}
