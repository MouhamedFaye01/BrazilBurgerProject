<?php

namespace  App\DataPersister;

// use App\Entity\User;
use App\Entity\Livraison;
use App\Services\MailerServices;
use App\Repository\LivreurRepository;
use App\Repository\LivraisonRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
// use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LivraisonDataPersister implements DataPersisterInterface
{

    public function __construct(
        // private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager,
        private TokenStorageInterface $tokenStorage,
        private LivreurRepository $Repo,
        private MailerServices $mailerServices,
        private LivraisonRepository $LRepo


    ) {
        // $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->token = $tokenStorage->getToken();
        // $this->mailer = $mailer;
    }

    public function supports($data): bool
    {
        return $data instanceof Livraison;
    }

    /**
     * @param Livraison $data
     */

    public function persist($data)
    {
        dd('dd');
        $livreurDispo = $this->Repo->findBy([
            "disponibility"=>true,
            "etat"=>1
        ]);
        // if (empty($livreurDispo) ) {
        //     return new JsonResponse(["message"=>"Pas de livreurs dispos"],400);
        // }


        // $hashedPassword = $this->passwordHasher->hashPassword($data, 'passer');
        // $data->setPassword($hashedPassword);

        $data->setGestionnaire($this->token->getUser());
        

        $this->entityManager->persist($data);
        // $this->mailerServices->sendEmail();
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
