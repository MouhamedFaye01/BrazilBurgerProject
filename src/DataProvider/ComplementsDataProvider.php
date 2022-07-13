<?php
namespace App\DataProvider;

use App\Entity\Complements;
use App\Repository\FrittesRepository;
use App\Repository\TailleBoissonRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

class ComplementsDataProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface
{
    
    public function __construct(TailleBoissonRepository $boissonRepository, FrittesRepository $frittesRepository)
    {
        $this->boissonRepository=$boissonRepository;
        $this->frittesRepository=$frittesRepository;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []){
        $complements=[
            'tailleBoisson'=>$this->boissonRepository->findAll(),
            'frittes'=>$this->frittesRepository->findAll()
        ];
        
        return $complements;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool{
        return $resourceClass === Complements::class;
    }


}