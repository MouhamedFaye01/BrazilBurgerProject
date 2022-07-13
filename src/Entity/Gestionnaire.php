<?php

namespace App\Entity;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Livraison;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ApiResource()]
#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
class Gestionnaire extends User
{
    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Produit::class)]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Commande::class)]
    private $ticket;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Livraison::class)]
    private $livraisons;

    public function __construct()
    {
        parent::__construct();
        $this->addRoles("ROLE_GESTIONNAIRE");
        $this->gestionnaire = new ArrayCollection();
        $this->ticket = new ArrayCollection();
        $this->livraisons = new ArrayCollection();
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getGestionnaire(): Collection
    {
        return $this->gestionnaire;
    }

    public function addGestionnaire(Produit $gestionnaire): self
    {
        if (!$this->gestionnaire->contains($gestionnaire)) {
            $this->gestionnaire[] = $gestionnaire;
            $gestionnaire->setGestionnaire($this);
        }

        return $this;
    }

    public function removeGestionnaire(Produit $gestionnaire): self
    {
        if ($this->gestionnaire->removeElement($gestionnaire)) {
            // set the owning side to null (unless already changed)
            if ($gestionnaire->getGestionnaire() === $this) {
                $gestionnaire->setGestionnaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getTicket(): Collection
    {
        return $this->ticket;
    }

    public function addTicket(Commande $ticket): self
    {
        if (!$this->ticket->contains($ticket)) {
            $this->ticket[] = $ticket;
            $ticket->setGestionnaire($this);
        }

        return $this;
    }

    public function removeTicket(Commande $ticket): self
    {
        if ($this->ticket->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getGestionnaire() === $this) {
                $ticket->setGestionnaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setGestionnaire($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getGestionnaire() === $this) {
                $livraison->setGestionnaire(null);
            }
        }

        return $this;
    }
}
