<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Controller\ValidateEmailActions;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "role", type: "string")]
#[ORM\DiscriminatorMap(["gestionnaire" => "Gestionnaire", "livreur" => "Livreur", "client" => "Client"])]
#[ApiResource(

    //---------------Validation du mail-----------------//
    collectionOperations:[
        "validation"=>[
            'method'=>'PATCH',
            'deserialize'=>false,
            'path'=>'user/validate/{token}',
            'controller'=>ValidateEmailActions::class
        ]
    ]
)

]


class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    protected $email;

    #[ORM\Column(type: 'json')]
    protected $roles = [];

    #[ORM\Column(type: 'string')]
    protected $password;

    #[ORM\Column(type: 'string', length: 255)]
    protected $nom;

    #[ORM\Column(type: 'string', length: 255)]
    protected $prenom;

    #[ORM\Column(type: 'integer',options:['default'=>1])]
    protected $etat=1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $number;

    #[ORM\Column(type: 'boolean',options:['default'=>false])]
    private $isEnable=false;

    #[ORM\Column(type: 'string', length: 255)]
    private $token;

    #[ORM\Column(type: 'datetime')]
    private $ExpireAt;

    
    public function __construct()
    {
        $this->ExpireAt=new \DateTime("+1 day");
        $this->generateToken();
    }

    public function generateToken()
    {
        // $this->ExpireAt =new \DateTime("+1 day");
        $this->token= bin2hex(openssl_random_pseudo_bytes(64));
    } 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
  
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

   


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_VISITEUR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    public function addRoles(string $role): self
    {
        $this->roles[]= $role;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }


    public function isIsEnable(): ?bool
    {
        return $this->isEnable;
    }

    public function setIsEnable(bool $isEnable): self
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->ExpireAt;
    }

    public function setExpireAt(\DateTimeInterface $ExpireAt): self
    {
        $this->ExpireAt = $ExpireAt;

        return $this;
    }
}
