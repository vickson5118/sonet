<?php

namespace src;

class Partenaire{
    private ?int $id;
    private ?string $nom;
    private ?string $logo;

    public function getId(): ?int{
        return $this->id;
    }

    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function getNom(): ?string{
        return $this->nom;
    }

    public function setNom(?string $nom): void{
        $this->nom = $nom;
    }

    public function getLogo(): ?string{
        return $this->logo;
    }

    public function setLogo(?string $logo): void{
        $this->logo = $logo;
    }

}