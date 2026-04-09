<?php

namespace App\DataFixtures;

use App\Entity\Conference;
use App\Entity\Organization;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ConferenceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 30; $i++) {
            $start = $faker->dateTimeBetween('-1 year', '+2 year')->setTime(0, 0, 0);
            $end = $faker->dateTimeInInterval($start->format(\DateTimeInterface::ATOM), '+3 days');

            $conference = (new Conference())
                ->setName($faker->realText(50))
                ->setDescription($faker->realText(200))
                ->setAccessible($faker->boolean())
                ->setStartAt(\DateTimeImmutable::createFromMutable($start))
                ->setEndAt(\DateTimeImmutable::createFromMutable($end))
            ;
            for ($j = 0; $j < $faker->numberBetween(0,3); $j++) {
                $conference->addOrganization($this->getReference(OrganizationFixtures::ORG.$faker->randomDigit(), Organization::class));
            }

            $manager->persist($conference);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OrganizationFixtures::class,
        ];
    }
}
