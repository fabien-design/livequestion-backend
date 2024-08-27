<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const REFERENCE_IDENTIFIER = 'category_';
    private const CATEGORIES = [
        'Sport',
        'Politique',
        'Business',
        'Santé',
        'Musique',
        'Films',
        'Jeux Videos'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $category) {
            $newCategory = new Category();
            $newCategory->setName($category);
            $manager->persist($newCategory);
            $this->addReference(self::REFERENCE_IDENTIFIER . $category, $newCategory);
        }

        $manager->flush();
    }

}
