<?php
declare(strict_types = 1);

namespace src;

class Utilisateur{
    
    private ?int $id;
    private ?string $nom;
    private ?string $prenoms;
    private ?string $password;
    private ?string $email;
    private ?string $dateInscription;
    private ?int $typeCompte;
    private bool $bloquer;
    private ?string $motifBlocage;
    private ?string $dateBlocage;
    private bool $connect;

    public function getId(): ?int{
        return $this->id;
    }

    public function setId(?int $id) : void{
        $this->id = $id;
    }

    public function getNom(): ?string{
        return $this->nom;
    }

    public function setNom(?string $nom) : void{
        $this->nom = $nom;
    }

    public function getPrenoms(): ?string{
        return $this->prenoms;
    }

    public function setPrenoms(?string $prenoms) : void{
        $this->prenoms = $prenoms;
    }

    public function getPassword(): ?string{
        return $this->password;
    }

    public function setPassword(?string $password) : void{
        $this->password = $password;
    }

    public function getEmail(): ?string{
        return $this->email;
    }

    public function setEmail(?string $email) : void{
        $this->email = $email;
    }

    public function getDateInscription(): ?string{
        return $this->dateInscription;
    }

    public function setDateInscription(?string $dateInscription) : void{
        $this->dateInscription = $dateInscription;
    }
    
    public function getTypeCompte(): ?int{
        
        return $this->typeCompte;
    }
    
    public function setTypeCompte(?int $typeCompte) : void{
        $this->typeCompte = $typeCompte;
    }
    
    public function getBloquer(): bool{
        return $this->bloquer;
    }

    public function setBloquer(bool $bloquer) : void{
        $this->bloquer = $bloquer;
    }
    
    public function getMotifBlocage(): ?string{
        return $this->motifBlocage;
    }

    public function getDateBlocage(): ?string{
        return $this->dateBlocage;
    }

    public function setMotifBlocage(?string $motifBlocage) : void{
        $this->motifBlocage = $motifBlocage;
    }

    public function setDateBlocage(?string $dateBlocage) : void{
        $this->dateBlocage = $dateBlocage;
    }
    
    public function isConnect(): bool{
        return $this->connect;
    }

    public function setConnect(bool $connect): void{
        $this->connect = $connect;
    }

    
}

