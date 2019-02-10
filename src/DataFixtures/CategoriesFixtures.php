<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    const CATEGORIES = [
        [
            'name' => 'Soins énergétiques',
            'slug' => 'soins-energetiques',
            'description' => null,
        ],
        [
            'name' => 'Consultations orales',
            'slug' => 'consultations-orales',
            'description' => null,
        ],
    ];

    public function load(ObjectManager $manager)
    {

        foreach(self::CATEGORIES as $fixture) {
            $category = new Category();
            $category
                ->setName($fixture['name'])
                ->setSlug($fixture['slug'])
                ->setDescription($fixture['description'])
            ;

            $manager->persist($category);
        }

        $manager->flush();
    }
}
