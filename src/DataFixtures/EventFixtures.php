<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [FormatEventFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $event = new Event();
            $event->setTitle(ucfirst($faker->words(3, true)));
            $event->setDescription($faker->text(200));
            $event->setDate($faker->dateTimeBetween('-1 month', '+1 years'));
            $event->setPauseMinutes(rand(2, 5));
            $event->setPauseSeconds(rand(0, 59));
            $event->setRoundMinutes(rand(1, 2));
            $event->setRoundSeconds(rand(0, 59));
            $manager->persist($event);
            $event->setFormatEvent($this->getReference('formatEvent_' . rand(0, 3)));
        }
        $manager->flush();
    }
}
