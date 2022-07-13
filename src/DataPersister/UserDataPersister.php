<?php

namespace  App\DataPersister;

use App\Entity\User;
use App\Services\MailerServices;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserDataPersister implements DataPersisterInterface
{

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager,
        private TokenStorageInterface $tokenStorage,
        private MailerServices $mailerServices
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->token = $tokenStorage->getToken();
        // $this->mailer = $mailer;
    }

    public function supports($data): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */

    public function persist($data)
    {
        $hashedPassword = $this->passwordHasher->hashPassword($data, 'passer');
        $data->setPassword($hashedPassword);
        $this->entityManager->persist($data);
        $this->mailerServices->sendEmail($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
