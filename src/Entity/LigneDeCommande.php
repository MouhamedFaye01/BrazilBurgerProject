<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LigneDeCommandeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LigneDeCommandeRepository::class)]

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
                "status" => Response::HTTP_OK,
                "denormalization_context" => [
                    "groups" => [
                        "write:Produit:collection",

                    ]
                ]
            ],
        ],
        itemOperations: [
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

class LigneDeCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]

    private $id;

    #[ORM\Column(type: 'integer')]

    #[Groups([
        "read:LigneCommande:collection",
        "read:LigneCommande:item",
        "write:Commande:collection"


    ])]
    private $quantite;

    #[ORM\Column(type: 'string',nullable:false, length: 255)]
    private $prixUnitaire=1200;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'ligneDeCommandes')]
    private $commande;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'lignesDeCommandes', cascade: ["persist"])]
    #[Groups([
        "write:Commande:collection",


    ])]
    private $produit;


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

    public function getPrixUnitaire(): ?string
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(string $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
}
