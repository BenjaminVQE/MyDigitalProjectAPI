<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $roles = [
            'User' => 'ROLE_USER',
            'Admin' => 'ROLE_ADMIN',
        ];

        return [
            TextField::new('company')->setLabel('Entreprise'),
            TextField::new('lastName')->setLabel('Nom'),
            TextField::new('firstName')->setLabel('Prénom'),
            EmailField::new('email')->setLabel('Email'),
            TextField::new('password')->setFormType(PasswordType::class)->onlyOnForms()->setLabel('Mot de passe'),
            TelephoneField::new('phoneNumber')->setLabel('Numéro de téléphone'),
            ChoiceField::new('roles', 'Rôles')->setChoices($roles)->allowMultipleChoices(true),
        ];
    }
}
