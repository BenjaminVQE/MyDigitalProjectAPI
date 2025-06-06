<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user')
                ->formatValue(function ($value, $entity) {
                    return $value?->getFullName();
                }),
            CollectionField::new('orderArticles')
                ->setTemplatePath('admin/order_articles.html.twig')
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(\EasyCorp\Bundle\EasyAdminBundle\Config\Action::NEW, \EasyCorp\Bundle\EasyAdminBundle\Config\Action::EDIT);
    }
}
