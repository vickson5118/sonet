<?php
declare(strict_types=1);
namespace src;

use JsonSerializable;

class Client implements JsonSerializable{
    
    private ?int $id;
    private ?string $nom;
    
    public function getId() : ?int{
        return $this->id;
    }

    public function getNom() : ?string{
        return $this->nom;
    }

    public function setId(?int $id) : void{
        $this->id = $id;
    }

    public function setNom(?string $nom): void{
        $this->nom = $nom;
    }
    public function jsonSerialize(): array{
        return array(
            "id" =>$this->id,
            "nom" => $this->nom
        );
    }

    
}

