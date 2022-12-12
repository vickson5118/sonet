<?php
declare(strict_types=1);
namespace src;

class File{
    
    private ?int $id;
    private Projet $projet;
    private ?string $chemin;
    
    public function getId() : ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getProjet() : Projet{
        return $this->projet;
    }

    public function setProjet(Projet $projet) : void{
        $this->projet = $projet;
    }

    public function getChemin() : ?string{
        return $this->chemin;
    }

    public function setChemin(?string $chemin) : void {
        $this->chemin = $chemin;
    }

    
    
    
}

