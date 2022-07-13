<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
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


class Burger extends Produit
{
  
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'burger')]
    private $menus;

    #[ORM\ManyToMany(targetEntity: TailleBoisson::class, inversedBy: 'burgers')]
    private $tailleboisson;

    #[ORM\ManyToMany(targetEntity: Frittes::class, inversedBy: 'burgers')]
    private $frittes;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenuBurgers::class)]
    private $menuBurgers;

    public function __construct()
    {
        // $this->menus = new ArrayCollection();
        $this->tailleboisson = new ArrayCollection();
        $this->frittes = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
    }

  

    /**
     * @return Collection<int, Menu>
     */
    // public function getMenus(): Collection
    // {
    //     return $this->menus;
    // }

    // public function addMenu(Menu $menu): self
    // {
    //     if (!$this->menus->contains($menu)) {
    //         $this->menus[] = $menu;
    //         $menu->addBurger($this);
    //     }

    //     return $this;
    // }

    // public function removeMenu(Menu $menu): self
    // {
    //     if ($this->menus->removeElement($menu)) {
    //         $menu->removeBurger($this);
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailleboisson(): Collection
    {
        return $this->tailleboisson;
    }

    public function addTailleboisson(TailleBoisson $tailleboisson): self
    {
        if (!$this->tailleboisson->contains($tailleboisson)) {
            $this->tailleboisson[] = $tailleboisson;
        }

        return $this;
    }

    public function removeTailleboisson(TailleBoisson $tailleboisson): self
    {
        $this->tailleboisson->removeElement($tailleboisson);

        return $this;
    }

    /**
     * @return Collection<int, Frittes>
     */
    public function getFrittes(): Collection
    {
        return $this->frittes;
    }

    public function addFritte(Frittes $fritte): self
    {
        if (!$this->frittes->contains($fritte)) {
            $this->frittes[] = $fritte;
        }

        return $this;
    }

    public function removeFritte(Frittes $fritte): self
    {
        $this->frittes->removeElement($fritte);

        return $this;
    }

    /**
     * @return Collection<int, MenuBurgers>
     */
    public function getMenuBurgers(): ?Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurgers $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurgers $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurger() === $this) {
                $menuBurger->setBurger(null);
            }
        }

        return $this;
    }
}



