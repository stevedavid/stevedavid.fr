<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ServicesFixtures extends Fixture
{
    const SERVICES = [
        [
            'name' => 'Douleurs physiques',
            'slug' => 'douleurs-physiques',
            'price' => 60,
            'duration' => 60,
            'description' => <<<EOF

EOF
,
            'summary' => <<<EOF
L'utilisation du magnétisme permet de soulager presque instantanément n'importe quelle douleur physique dont vous pourriez être atteint. J'interviens sur vos corps subtils pour guérir votre corps physique.
EOF
,
            'remotable' => true,
            'category' => 'soins-energetiques'
        ],
        [
            'name' => 'Stress et anxiété',
            'slug' => 'stress-et-anxiete',
            'price' => 60,
            'duration' => 60,
            'description' => <<<EOF

EOF
            ,
            'summary' => <<<EOF
Les énergies peuvent être fortement bienfaitrices en termes de bien-être et de relaxation. En intervant sur vos chakras supérieurs, je suis à même de calmer n'importe laquelle de vos angoisses.
EOF
            ,
            'remotable' => true,
            'category' => 'soins-energetiques'
        ],
        [
            'name' => 'Addictions',
            'slug' => 'addictions',
            'price' => 60,
            'duration' => 60,
            'description' => <<<EOF

EOF
            ,
            'summary' => <<<EOF
Afin de vous aider à vous libérer de vos addictions, je peux utiliser le magnétisme pour agir sur vos corps subtils. Je traite les raisons de vos addictions sur un plan énergétique afin de vous aider à ne plus ressentir le besoin de les satisfaire.
EOF
            ,
            'remotable' => true,
            'category' => 'soins-energetiques'
        ],
        [
            'name' => 'Psychologie divinatoire',
            'slug' => 'psychologie-divinatoire',
            'price' => 50,
            'duration' => 60,
            'description' => <<<EOF

EOF
,
            'summary' => <<<EOF
Mes jeux de tarots et d'oracles peuvent se révéler être de formidables outils de développement personnel. Si vous êtes de nature à vous interroger sur vos comportements et vos schémas de pensées, apprenez, grâce à la cartomancie, à vous connaître et à comprendre votre fonctionnement.
EOF
,
            'remotable' => true,
            'category' => 'consultations-orales',
        ],
        [
            'name' => 'Etude tarologique',
            'slug' => 'etude-tarologique',
            'price' => 50,
            'duration' => 60,
            'description' => <<<EOF

EOF
,
            'summary' => <<<EOF
Grâce à mes jeux de tarots et d'oracles, étudiez certaines situations présentes et passées de votre vie. Vous pourrez en apprendre plus sur les tenants et les aboutissants de chacune d'entre elles. Découvrez la meilleure attitude à adopter en toutes circonstances.
EOF
,
            'remotable' => true,
            'category' => 'consultations-orales',
        ],
        [
            'name' => 'Eveil à la spiritualité',
            'slug' => 'eveil-a-la-spiritualite',
            'price' => 50,
            'duration' => 60,
            'description' => <<<EOF

EOF
,
            'summary' => <<<EOF
Je dispose de tout un panel de facultés et de capacités extra-sensorielles et je suis fortement sensibles aux notions et aux concepts issus de la spiritualité. Dès lors, nous pouvons nous entretenir sur vos interrogations à ce sujet. N'oubliez pas que tout le monde possède du magnétisme et chacun d'entre nous a la capacité d'entrer en contact avec sa guidance.
EOF
,
            'remotable' => true,
            'category' => 'consultations-orales',
        ],
    ];

    public function load(ObjectManager $manager)
    {

        $repository = $manager->getREpository(Category::class);

        foreach(self::SERVICES as $fixture) {
            $service = new Service();
            $service
                ->setName($fixture['name'])
                ->setSlug($fixture['slug'])
                ->setPrice($fixture['price'])
                ->setDuration($fixture['duration'])
                ->setDescription($fixture['description'])
                ->setSummary($fixture['summary'])
                ->setRemotable($fixture['remotable'])
                ->setCategory($repository->findOneBySlug($fixture['category']))
            ;

            $manager->persist($service);
        }

        $manager->flush();
    }
}
