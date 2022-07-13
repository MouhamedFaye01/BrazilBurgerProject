<?php

namespace App\Entity;

use App\Entity\Livraison;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\Menu2Controller;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
// use Symfony\Component\Validator\Constraints\Cascade;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[
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
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]

    #[Groups([
        "read:Commande:collection",
        "read:Commande:item",
        "write:Livraison:collection",
        "write:Livraison:item"
    ])]
    
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $RegistrationDate;




    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "read:Commande:item"
    ])]
    private $etat = "en cours";

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneDeCommande::class, cascade: ["persist"])]
    #[Groups([
        "write:Commande:collection",
        "read:Commande:collection"
    ])]
    #[SerializedName("Produits")]
    private $ligneDeCommandes;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]

    private $client;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'ticket')]
    private $gestionnaire;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    public function __construct()
    {
        $this->ligneDeCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?self
    {
        return $this->commande;
    }

    public function setCommande(?self $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */


    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->RegistrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $RegistrationDate): self
    {
        $this->RegistrationDate = $RegistrationDate;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, LigneDeCommande>
     */
    public function getLigneDeCommandes(): Collection
    {
        return $this->ligneDeCommandes;
    }

    public function addLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if (!$this->ligneDeCommandes->contains($ligneDeCommande)) {
            $this->ligneDeCommandes[] = $ligneDeCommande;
            $ligneDeCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if ($this->ligneDeCommandes->removeElement($ligneDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneDeCommande->getCommande() === $this) {
                $ligneDeCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }
}
