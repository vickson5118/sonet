<?php
declare(strict_types = 1);
namespace src;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Functions.php");

class Contact {
    private ?int $id;
    private ?string $nom;
    private ?string $prenoms;
    private ?string $telephone;
    private ?string $email;
    private ?string $objet;
    private ?string $message;
    private ?string $dateEnvoi;
    private bool $view;

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

    public function getPrenoms(): ?string{
        return $this->prenoms;
    }

    public function setPrenoms(?string $prenoms): void{
        $this->prenoms = $prenoms;
    }

    public function getTelephone(): ?string{
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): void{
        $this->telephone = $telephone;
    }

    public function getEmail(): ?string{
        return $this->email;
    }

    public function setEmail(?string $email): void{
        $this->email = $email;
    }

    public function getObjet(): ?string{
        return $this->objet;
    }

    public function setObjet(?string $objet): void{
        $this->objet = $objet;
    }

    public function getMessage(): ?string{
        return $this->message;
    }

    public function setMessage(?string $message): void{
        $this->message = $message;
    }

    public function getDateEnvoi(): ?string{
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(?string $dateEnvoi): void{
        $this->dateEnvoi = $dateEnvoi;
    }

    public function isView(): bool{
        return $this->view;
    }

    public function setView(bool $view): void{
        $this->view = $view;
    }
}

