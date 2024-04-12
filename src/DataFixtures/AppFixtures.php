<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

// Assure-toi d'importer l'entité Comment

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $blog = new Blog();
            $blog->setTitle($faker->sentence) // Utilise sentence pour un titre plus réaliste
            ->setContent($faker->paragraphs(asText: true)) // Génère plusieurs paragraphes pour le contenu
            ->setDate($faker->dateTimeThisYear()); // Génère une date aléatoire de cette année

            $manager->persist($blog);

// Créons également quelques commentaires pour chaque blog
            for ($j = 0; $j < mt_rand(3, 10); $j++) { // Nombre aléatoire de commentaires par blog
                $comment = new Comment();
                $comment->setPseudo($faker->name)
                    ->setContent($faker->paragraph)
                    ->setBlog($blog)
                    ->setDate(date('Y-m-d H:i', rand(strtotime("2022-01-01"), time())));

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
