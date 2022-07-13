<?php

namespace App\Entity;

use App\Entity\Complements;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[
    ApiResource(
        collectionOperations: [
            "GET" => [
                "status" => Response::HTTP_OK,
                "normalization_context" => [
                    "groups" => [
                        "read:Produit:collection",
                    ]
                ]
            ],
            "POST" => [
                "denormalization_context" => [
                    "groups" => [
                        "write:Produit:collection",
                    ]
                ]
            ]
        ],
        itemOperations: [
            "PUT" => [
                "denormalization_context" => [
                    "groups" => [
                        "write:Produit:item",
                    ]
                ]
            ],
            "GET" => [
                "normalization_context" => [
                    "groups" => [
                        "read:Produit:item",
                    ]
                ]
            ],

        ]
    )
]
class TailleBoisson extends Produit
{
   

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'boisson')]
    private $menus;

    #[ORM\ManyToMany(targetEntity: Burger::class, mappedBy: 'tailleboisson')]
    private $burgers;

    #[ORM\Column(type: 'string', length: 255)]
    private $tailleBoisson;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->burgers = new ArrayCollection();
    }

  
    // /**
    //  * @return Collection<int, Menu>
    //  */
    // public function getMenus(): Collection
    // {
    //     return $this->menus;
    // }

    // public function addMenu(Menu $menu): self
    // {
    //     if (!$this->menus->contains($menu)) {
    //         $this->menus[] = $menu;
    //         $menu->addBoisson($this);
    //     }

    //     return $this;
    // }

    // public function removeMenu(Menu $menu): self
    // {
    //     if ($this->menus->removeElement($menu)) {
    //         $menu->removeBoisson($this);
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Burger>
    //  */
    // public function getBurgers(): Collection
    // {
    //     return $this->burgers;
    // }

    // public function addBurger(Burger $burger): self
    // {
    //     if (!$this->burgers->contains($burger)) {
    //         $this->burgers[] = $burger;
    //         $burger->addTailleboisson($this);
    //     }

    //     return $this;
    // }

    // public function removeBurger(Burger $burger): self
    // {
    //     if ($this->burgers->removeElement($burger)) {
    //         $burger->removeTailleboisson($this);
    //     }

    //     return $this;
    // }

    // public function getTailleBoisson(): ?string
    // {
    //     return $this->tailleBoisson;
    // }

    // public function setTailleBoisson(string $tailleBoisson): self
    // {
    //     $this->tailleBoisson = $tailleBoisson;

    //     return $this;
    // }
}
