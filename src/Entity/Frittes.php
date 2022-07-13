<?php

namespace App\Entity;

// use App\Entity\Complements;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FrittesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: FrittesRepository::class)]
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
class Frittes extends Produit
{

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'frittes')]
    private $menus;

    #[ORM\ManyToMany(targetEntity: Burger::class, mappedBy: 'frittes')]
    private $burgers;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->burgers = new ArrayCollection();
    }

  

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addFritte($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeFritte($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
            $burger->addFritte($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            $burger->removeFritte($this);
        }

        return $this;
    }
}
