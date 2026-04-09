<?php

namespace App\DataFixtures;

use App\Entity\Organization;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OrganizationFixtures extends Fixture
{
    public const ORG = 'org_';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $organization = (new Organization())
                ->setName($faker->company())
                ->setPresentation($faker->realText(200))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable(
                    $faker->dateTimeBetween('-10 years', 'now')->setTime(0, 0, 0)
                ))
            ;

            $manager->persist($organization);
            $this->setReference(self::ORG.$i, $organization);
        }

        $manager->flush();
    }
}
