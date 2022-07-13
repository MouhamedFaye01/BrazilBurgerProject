<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
      collectionOperations:[
        'GET'=>[
              "path"=>"/complements"
        ]
      ],
      itemOperations:[

      ]
)]
class Complements 
{
  #[ApiProperty(
    identifier: true
  )]
  private $id;


}
