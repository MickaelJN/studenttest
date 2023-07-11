<?php

namespace App\DataFixtures;

use App\Entity\Student;
use App\Entity\Grade;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        
        $student = new Student();
        $student->setLastname("Jacinto Nunes");
        $student->setFirstname("Mickaël");
        $student->setDateOfBirth(new \DateTimeImmutable("1984-11-03"));
        $manager->persist($student);
        
        $php = new Grade();
        $php->setSubject("PHP");
        $php->setScore(15.00);
        $php->setStudent($student);
        $manager->persist($php);        
        
        $js = new Grade();
        $js->setSubject("JS");
        $js->setScore(13.50);
        $js->setStudent($student);
        $manager->persist($js);
        
        $manager->flush();
    }
}
