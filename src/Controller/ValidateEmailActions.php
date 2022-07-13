<?php
namespace App\Controller;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ValidateEmailActions extends AbstractController
{
   
    
    public function __invoke(Request $request, UserRepository $UserRepo, EntityManagerInterface $manager)
    {
        
         $token = $request->get('token');
        $user = $UserRepo->findOneBy(['token' => $token]);
        if (!$user) {
            return new JsonResponse(['token'=>'token invalide'],Response::HTTP_BAD_REQUEST);
        }
        if($user->isIsEnable()){
            return new JsonResponse(['token'=>'Le compte est déjà activé'],Response::HTTP_BAD_REQUEST);
        }
        if($user->getExpireAt() < new \DateTime()){
            return new JsonResponse(['token'=>'Token invalide'],Response::HTTP_BAD_REQUEST);
        }
        $user->setIsEnable(true);
        $manager->flush();
        return new JsonResponse(['message'=>'Votre compte a été activé avec suucès']); 



    }
    
}