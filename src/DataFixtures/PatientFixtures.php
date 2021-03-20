<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PatientFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++){
            $patient = new Patient();
            $patient->setNom("le nom du patient n°$i")
                ->setPrenom("le prenom du patient n°$i")
                ->setDateNaissance(new \DateTime())
                ->setEmail("lemail du patient n°$i")
                ->setTelephone("le tel du patient n°$i")
                ->setAntecedents("les antecedents du patient n°$i")
                ->setSecu("le nom du patient n°$i")
                ->setDatecrea(new \DateTime());

            $manager->persist($patient);
            }

        $manager->flush();
    }
}
