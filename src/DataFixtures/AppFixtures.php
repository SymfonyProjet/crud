<?php

namespace App\DataFixtures;

use App\Entity\Aliment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $aliment1 = new Aliment();
        $aliment1->setNom("Pomme")
                 ->setPrix(2)
                 ->setCalorie(145)
                 ->setImage("pomme.jpg")
                 ->setProteine(0.22)
                 ->setGlucide(12.3)
                 ->setLipide(0.1)
        ;
        $manager->persist($aliment1);

        $aliment2 = new Aliment();
        $aliment2->setNom("Aubergine")
                 ->setPrix(3)
                 ->setCalorie(75)
                 ->setImage("aubergine.jpg")
                 ->setProteine(7.22)
                 ->setGlucide(1.3)
                 ->setLipide(7.1)
        ;
        $manager->persist($aliment2);

        $aliment3 = new Aliment();
        $aliment3->setNom("Poire")
                 ->setPrix(3.5)
                 ->setCalorie(75)
                 ->setImage("poire.jpg")
                 ->setProteine(0.22)
                 ->setGlucide(45.3)
                 ->setLipide(0.41)
        ;
        $manager->persist($aliment3);

        $aliment4 = new Aliment();
        $aliment4->setNom("Lait")
                 ->setPrix(0.5)
                 ->setCalorie(95)
                 ->setImage("lait.jpg")
                 ->setProteine(8.22)
                 ->setGlucide(25.3)
                 ->setLipide(2.41)
        ;
        $manager->persist($aliment4);

        $manager->flush();
    }
}
