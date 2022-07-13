<?php

namespace App\DataFixtures;

use App\Entity\Client;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{
    private $HashPassword;
    public function __construct(UserPasswordHasherInterface $HashPassword)
    {
        $this->HashPassword = $HashPassword;
    }
    
    public function load(ObjectManager $manager): void
    {
        $client = new Client();
        $client->setNom('Ndiaye');
        $client->setPrenom('Mor');
        $client->setEmail('Mor@gmail.com');
        $client->setPassword($this->HashPassword->hashPassword($client,'Mor'));
        $client->setNumber('779895647');
        $client->setAdresse('GW');
        $client->setExpireAt(new \DateTime());


        $manager->persist($client);
        $manager->flush();
    }
}
