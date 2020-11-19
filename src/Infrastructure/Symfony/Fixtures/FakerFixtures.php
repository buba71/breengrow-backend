<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Fixtures;

use App\Infrastructure\Symfony\Doctrine\Entity\Company;
use App\Infrastructure\Symfony\Doctrine\Entity\GeoPoint;
use App\Infrastructure\Symfony\Doctrine\Entity\Grower;
use App\Infrastructure\Symfony\Doctrine\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

final class FakerFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++) {
            $grower = new Grower();
            $grower->setId($faker->uuid);
            $grower->setFirstName($faker->firstName);
            $grower->setLastName($faker->name);
            
            $user = new User();
            $user->setParentId($grower->getId());
            $user->setEmail($faker->email);
            $user->setPassword('$2y$13$.G6dF3T8fnhF9J6h4cRNteu0g6eXFzwtYlrcqnJRQGIxErza7G1be');
            $user->setRoles(['ROLE_GROWER']);
            
            $hive = new Company();
            $hive->setName($faker->company);
            $hive->setStreet($faker->streetAddress);
            $hive->setZipCode($faker->postcode);
            $hive->setCity($faker->city);
            $hive->setSiretNumber('849545455');
            
            $geoPoint = new GeoPoint();
            $geoPoint->setLatitude($faker->latitude);
            $geoPoint->setLongitude($faker->longitude);
            
            $hive->setGeoPoint($geoPoint);
            $grower->setUser($user);
            $grower->setCompany($hive);

            $manager->persist($grower);
        }
        $manager->flush();
    }
}
