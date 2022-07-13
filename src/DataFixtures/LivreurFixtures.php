<?php

namespace App\DataFixtures;

use App\Entity\Livreur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LivreurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $livreur = new Livreur();
        // $manager->persist($product);

        $manager->flush();
    }
}
