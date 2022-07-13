<?php

namespace App\Entity;

use App\Entity\Burger;
use App\Entity\Produit;
use App\Entity\MenuBurgers;
use App\Entity\TailleBoisson;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: MenuRepository::class)] #[
    ApiResource(
        collectionOperations: [
            "GET" => [
                "status" => Response::HTTP_OK,
                "normalization_context" => [
                    "groups" => [
                        "read:Commande:collection",
                    ]
                ]
            ],
            "POST" => [
                "denormalization_context" => [
                    "groups" => [
                        "write:Commande:collection",
                    ]
                ]
            ],
            "MENU_2" => [
                "status" => Response::HTTP_OK,
                "method" => 'POST',
                "path" => "/menus2",
                "controller" => Menu2Controller::class
            ]


        ],
        itemOperations: [
            "PUT" => [
                "denormalization_context" => [
                    "groups" => [
                        "write:Commande:item",
                    ]
                ]
            ],
            "GET" => [
                "normalization_context" => [
                    "groups" => [
                        "read:Commande:item",
                    ]
                ]
            ],

        ]
    )
]


class Menu extends Produit
{

    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    private $burger;

    #[ORM\ManyToMany(targetEntity: TailleBoisson::class, inversedBy: 'menus')]
    private $boisson;

    #[ORM\ManyToMany(targetEntity: Frittes::class, inversedBy: 'menus')]
    private $frittes;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurgers::class, cascade: ['persist'])]
    private $menuBurgers;

    public function __construct()
    {
        $this->burger = new ArrayCollection();
        $this->boisson = new ArrayCollection();
        $this->frittes = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
    }

    /**
    //  * @return Collection<int, Burger>
     */
    // public function getBurger(): Collection
    // {
    //     return $this->burger;
    // }

    // public function addBurger(Burger $burger): self
    // {
    //     if (!$this->burger->contains($burger)) {
    //         $this->burger[] = $burger;
    //     }

    //     return $this;
    // }

    // public function removeBurger(Burger $burger): self
    // {
    //     $this->burger->removeElement($burger);

    //     return $this;
    // }

    /**
    //  * @return Collection<int, TailleBoisson>
    //  */
    // public function getBoisson(): Collection
    // {
    //     return $this->boisson;
    // }

    // public function addBoisson(TailleBoisson $boisson): self
    // {
    //     if (!$this->boisson->contains($boisson)) {
    //         $this->boisson[] = $boisson;
    //     }

    //     return $this;
    // }

    // public function removeBoisson(TailleBoisson $boisson): self
    // {
    //     $this->boisson->removeElement($boisson);

    //     return $this;
    // }

    /**
    //  * @return Collection<int, Frittes>
     */
    // public function getFrittes(): Collection
    // {
    //     return $this->frittes;
    // }

    // public function addFritte(Frittes $fritte): self
    // {
    //     if (!$this->frittes->contains($fritte)) {
    //         $this->frittes[] = $fritte;
    //     }

    //     return $this;
    // }

    // public function removeFritte(Frittes $fritte): self
    // {
    //     $this->frittes->removeElement($fritte);

    //     return $this;
    // }

    /**
     * @return Collection<int, MenuBurgers>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurgers $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurgers $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

        return $this;
    }
    public function addBurger(Burger $burger, int $qt = 1)
    {
        $mb = new MenuBurgers();
        $mb->setBurger($burger);
        $mb->setMenu($this);
        $mb->setQuantite($qt);
        $this->addMenuBurger($mb);
    }
    public function addBoisson(TailleBoisson $boisson, int $qt = 1)
    {
        $mb = new MenuBurgers();
        $mb->setBoisson($boisson);
        $mb->setMenu($this);
        $mb->setQuantite($qt);
        $this->addMenuBurger($mb);
    }
}
