<?php

namespace App\Entity;

use App\Entity\LigneDeCommande;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]


//-----Que je peux use que des PUT ET GET ------//
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

//-----HÉRITAGE--------//

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "valeur", type: "string")]
#[ORM\DiscriminatorMap(["burger" => "Burger", "menu" => "Menu", "tailleboisson" => "TailleBoisson", "frittes" => "Frittes"])]



class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups([
        "write:Commande:collection",
        "read:Produit:collection"
    ])]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "read:Produit:collection",
        "write:Produit:collection",
        "read:Produit:item",
        "write:Produit:item"
    ])]
    protected $nom;

    #[ORM\Column(type: 'boolean')]
    protected $etat;

    #[ORM\Column(type: 'float')]
    #[Groups([
        "read:Produit:collection",
        "write:Produit:collection",
        "read:Produit:item",
        "write:Produit:item"
    ])]
    protected $prix;



    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'gestionnaire')]
    #[Groups([
        "read:Produit:collection",
        "read:Produit:item"
    ])]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneDeCommande::class)]
    private $lignesDeCommandes;


    public function __construct()
    {
        $this->ligneDeCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

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



    /**
     * @return Collection<int, LigneDeCommande>
     */
    public function getLigneDeCommandes(): ?Collection
    {
        return $this->ligneDeCommandes;
    }

    public function addLignesDeCommande(LigneDeCommande $lignesDeCommande): self
    {
        if (!$this->lignesDeCommandes->contains($lignesDeCommande)) {
            $this->lignesDeCommandes[] = $lignesDeCommande;
            $lignesDeCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLignesDeCommande(LigneDeCommande $lignesDeCommande): self
    {
        if ($this->lignesDeCommandes->removeElement($lignesDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($lignesDeCommande->getProduit() === $this) {
                $lignesDeCommande->setProduit(null);
            }
        }

        return $this;
    }
}
