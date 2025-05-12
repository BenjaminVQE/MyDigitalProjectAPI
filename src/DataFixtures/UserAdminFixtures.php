<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserAdminFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $userAdmin = new User();
        $userAdmin->setEmail('admin@gmail.com');
        $userAdmin->setLastName('Doe');
        $userAdmin->setFirstName('John');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $userAdmin->setCompany('MDS');
        $userAdmin->setPhoneNumber('0678930495');


        $password = $this->hasher->hashPassword($userAdmin, 'admin123-');
        $userAdmin->setPassword($password);

        $manager->persist($userAdmin);

        $this->addReference(self::ADMIN_USER_REFERENCE, $userAdmin);

        $manager->flush();
    }
}
