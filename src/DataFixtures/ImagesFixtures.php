<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImagesFixtures extends Fixture
{
    public const REFERENCE_IDENTIFIER = 'image_';

    private const IMAGES = [
        [
            'fake_id' => '1',
            'original_name' => 'img_train_vapeur.jpg',
            'extension' => 'image/jpeg',
        ],
        [
            'fake_id' => '2',
            'original_name' => 'jo-2024-natation-400m-4-nages-finale-leon-marchand-66a6353534d09-66c9a6fed8acc761373334.jpg',
            'extension' => 'image/jpeg',
        ],
        [
            'fake_id' => '3',
            'original_name' => 'foot_vs_rugby.png',
            'extension' => 'image/png',
        ],
        [
            'fake_id' => '4',
            'original_name' => 'valo_vs_cs.jpg',
            'extension' => 'image/jpeg',
        ],
        [
            'fake_id' => '5',
            'original_name' => 'bombardements-ukraine-octobre.jpg',
            'extension' => 'image/jpeg',
        ],
        [
            'fake_id' => '6',
            'original_name' => 'deadpool_wolverine.png',
            'extension' => 'image/png',
        ],
        [
            'fake_id' => '7',
            'original_name' => 'Meilleurs-joueurs-de-tennis-de-tous-les-temps-photo-joueurs-min.jpg',
            'extension' => 'image/jpeg',
        ],
        [
            'fake_id' => '8',
            'original_name' => '1200x680_maxnewsworldfive245539.jpg',
            'extension' => 'image/jpeg',
        ],
        [
            'fake_id' => '9',
            'original_name' => 'boxe_vs_mma.jpg',
            'extension' => 'image/jpeg',
        ],
        [
            'fake_id' => '10',
            'original_name' => 'messi-et-cristiano-ronaldo.jpg',
            'extension' => 'image/jpeg',
        ],
        [
            'fake_id' => '11',
            'original_name' => '60236223.jpeg',
            'extension' => 'image/jpeg',
        ],
        [
            'fake_id' => '12',
            'original_name' => 'avatar-person.avif',
            'extension' => 'image/avif',
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        $filesystem = new Filesystem();

        foreach(self::IMAGES as $image) {
            $src = __DIR__ . "/../../public/images/fixtures/" . $image['original_name'];
            
            // Create a temporary copy of the image
            $copyPath = __DIR__ . "/../../public/images/uploads/";
            $copyImgName =  uniqid() . '_' . 'image.jpg';
            $copyPath .= $copyImgName;
            $filesystem->copy($src, $copyPath);

            $file = new UploadedFile(
                $copyPath,
                $copyImgName,
                $image['extension'],
                null,
                true // Test mode is true
            );

            $imageEntity = new Images();
            $imageEntity->setImageFile($file);
            $manager->persist($imageEntity);
            $this->addReference(self::REFERENCE_IDENTIFIER . $image['fake_id'], $imageEntity);
        }

        $manager->flush();
    }
}
