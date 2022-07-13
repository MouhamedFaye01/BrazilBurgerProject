<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
  collectionOperations:[
    'GET'=>[
          "method"=>"get",
          "path"=>"/catalogues"
    ]
  ],
  itemOperations:[

  ]
)]
class Catalogue
{
    #[ApiProperty(
        identifier: true
      )]
      private $id;
      
}
