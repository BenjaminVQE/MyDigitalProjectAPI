<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminAction;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->setLabel('Nom'),
            TextField::new('width')->setLabel('Largeur'),
            TextField::new('height')->setLabel('Largeur'),
            TextField::new('length')->setLabel('Longueur'),
            TextField::new('price')->setLabel('Prix'),
            TextField::new('matter')->setLabel('Matière'),

        ];
    }
}
