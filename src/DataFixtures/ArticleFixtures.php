<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function __construct() {}

    public function load(ObjectManager $manager): void
    {
        $article = new Article();
        $article->setName('Trousse avec fond');
        $article->setWidth('5');
        $article->setHeight('6');
        $article->setLength('20');
        $article->setMatter('Tissu');
        $article->setPrice('5.90');

        $manager->persist($article);

        $manager->flush();
    }
}
