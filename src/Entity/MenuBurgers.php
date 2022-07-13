<?php

namespace App\Entity;

use App\Entity\Burger;
use App\Entity\TailleBoisson;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBurgersRepository;

#[ORM\Entity(repositoryClass: MenuBurgersRepository::class)]
class MenuBurgers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }
    // public function getBoisson(): ?Boisson
    // {
    //     return $this->boisson;
    // }

    public function setBoisson(?TailleBoisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}
