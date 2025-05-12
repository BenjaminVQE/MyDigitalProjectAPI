<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Address;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AddressFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        /*    $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {
            $address = new Address();

            $address->setAddressType($faker->randomElement(['livraison', 'facturation']));
            $address->setNameStreet($faker->streetAddress());
            $address->setCity($faker->city());
            $address->setPostalCode($faker->postcode());
            $address->setNumberStreet($faker->numberBetween(1, 50));

            $randomUserIndex = rand(0, 9);
            $user = $this->getReference('user_' . $randomUserIndex, User::class);
            $address->setUser($user);

            $manager->persist($address);
        }

        $manager->flush(); */
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
