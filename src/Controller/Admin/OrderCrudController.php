<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminAction;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {


        return [
            TextField::new('cart')->setLabel('Panier'),
            ChoiceField::new('user')
                ->setChoices(fn(?User $user) => $user->getFullName())
                ->setLabel('Utilisateur'),
        ];
    }
}
