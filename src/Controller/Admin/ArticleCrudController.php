<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

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
            NumberField::new('width')->setLabel('Largeur (cm)')
                ->formatValue(fn($value, $entity) => $value !== null ? $value . ' cm' : null),
            NumberField::new('height')->setLabel('Hauteur (cm)')
                ->formatValue(fn($value, $entity) => $value !== null ? $value . ' cm' : null),
            NumberField::new('length')->setLabel('Longueur (cm)')
                ->formatValue(fn($value, $entity) => $value !== null ? $value . ' cm' : null),
            NumberField::new('price')->setLabel('Prix (Euro)')
                ->formatValue(fn($value, $entity) => $value !== null ? $value . ' €' : null),
            TextField::new('matter')->setLabel('Matière'),
        ];
    }
}