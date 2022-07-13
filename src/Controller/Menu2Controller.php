<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Repository\BurgerRepository;
use App\Repository\FrittesRepository;
use App\Repository\TailleBoissonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class Menu2Controller extends AbstractController
{
    public function __invoke(Request $request, EntityManagerInterface $manager, BurgerRepository $br,FrittesRepository $fr,TailleBoissonRepository $tbr)
    {
        $content = json_decode($request->getContent());
        if (!isset($content->nom)) {
            return  $this->json('Nom Obligatoire', 400);
        }
        $menu = new Menu();
        $menu->setNom($content->nom);
        foreach ($content->burgers as $b) {
            $burger = $br->find($b->burger);
            if ($burger) {
                $menu->addBurger($burger, $b->quantite);
            }
        }
        // foreach ($content->boissons as $boi) {
        //     $boisson = $tbr->find($boi->boisson);
        //     if ($boisson) {

        //         $menu->addBoisson($boisson, $boi->quantite);
        //     }
        // }
        // foreach ($content->burgers as $b) {
        //     $burger = $br->find($b->burger);
        //     if ($burger) {

        //         $menu->addBurger($burger, $b->quantite);
        //     }
        // }
        $manager->persist($menu);
        $manager->flush();
        return  $this->json('Succes', 201);
    }
}
