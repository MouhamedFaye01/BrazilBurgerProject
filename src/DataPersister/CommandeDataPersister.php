<?php

namespace  App\DataPersister;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;




class CommandeDataPersister implements DataPersisterInterface
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
        return $data instanceof Commande;
    }

    /**
     * @param Commande $data
     */

    public function persist($data)

    {
        $user=$this->token->getUser();
        $data->setClient($user);
        $data->setRegistrationDate(new \DateTime);


        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}