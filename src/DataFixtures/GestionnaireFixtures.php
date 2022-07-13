<?php

namespace App\DataFixtures;

use App\Entity\Gestionnaire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class GestionnaireFixtures extends Fixture

{
    public function __construct(UserPasswordHasherInterface $HashPassword)
    {
        $this->HashPassword = $HashPassword;
    }
    public function load(ObjectManager $manager): void
    {
        $gestionnaire = new Gestionnaire();

        $gestionnaire->setNom('Ndiaye');
        $gestionnaire->setPrenom('Moussa');
        $gestionnaire->setEmail('Moussa@gmail.com');
        $gestionnaire->setPassword($this->HashPassword->hashPassword($gestionnaire,'Mor'));
        $gestionnaire->setNumber('779895647');
        $gestionnaire->setExpireAt(new \DateTime());

        $manager->persist($gestionnaire);

        $manager->flush();
    }
}
