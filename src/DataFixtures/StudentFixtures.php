<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Zend\Code\Generator\GeneratorInterface;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i=0;$i<=100;$i++) {
            $student = new Student();
            $student->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setCity($faker->randomElement(['La loupe', $faker->city]))
                ->setBirthAt($faker->dateTimeBetween('-90year','-18year'))
                ->setJob($faker->jobTitle)
                ->setSecretId($faker->numberBetween(10,99));
            $manager->persist($student);
        }
        $manager->flush();
    }
}
