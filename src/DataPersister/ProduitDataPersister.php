<?php

namespace  App\DataPersister;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ProduitDataPersister implements DataPersisterInterface
{
private TokenInterface $token;
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TokenStorageInterface $tokenStorage,
    ) {
        $this->entityManager = $entityManager;
        $this->token = $tokenStorage->getToken();
        
    }

    public function supports($data): bool
    {
        return $data instanceof Produit;
    }

    /**
     * @param Produit $data
     */

    public function persist($data)

    {
        $user=$this->token->getUser();
        $data->setGestionnaire($user);
        $data->setEtat(1);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}

