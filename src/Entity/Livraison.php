<?php

namespace App\Entity;

use App\Entity\Livreur;
use App\Entity\Commande;
use App\Entity\Gestionnaire;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(
    collectionOperations: [
        "GET" => [
            "status" => Response::HTTP_OK,
            "normalization_context" => [
                "groups" => [
                    "read:Livraison:collection",
                ]
            ]
        ],
        "POST" => [
            "denormalization_context" => [
                "groups" => [
                    "write:Livraison:collection",
                ]
            ],
            "normalization_context" => [
                "groups" => [
                    "read:Livraison:collection",
                ]
            ]
        ],


    ],
    itemOperations: [
        "PUT" => [
            "denormalization_context" => [
                "groups" => [
                    "write:Livraison:item",
                ]
            ]
        ],
        "GET" => [
            "normalization_context" => [
                "groups" => [
                    "read:Livraison:item",
                ]
            ]
        ],

    ]
)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        "read:Livraison:collection",
        "read:Livraison:item"

    ])]
    private $id;

    #[ORM\OneToMany(mappedBy: 'Livraison', targetEntity: Commande::class)]
    #[Groups([
        "read:Livraison:collection",
        "read:Livraison:item",
        "write:Livraison:collection",
        "write:Livraison:item"

    ])]
    private $commandes;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    #[Groups([
        "read:Livraison:collection",
        "read:Livraison:item"

    ])]
    private $livreur;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'livraisons')]
    #[Groups([
        "read:Livraison:collection",
        "read:Livraison:item",
        "write:Livraison:collection",
        "write:Livraison:item"

    ])]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'livraisons')]
    #[Groups([
        "read:Livraison:collection",
        "read:Livraison:item"

    ])]
    private $gestionnaire;


    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }
}
