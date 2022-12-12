<?php
declare(strict_types=1);
namespace src;

class Projet {
    
    private ?int $id;
    private ?string $titre;
    private ?string $titreUrl;
    private ?string $dateDebut;
    private ?string $dateFin;
    private Domaine $domaine;
    private Client $client;
    private Lieu $lieu;
    private ?string $description;
    private ?string $objectif;
    private ?string $resultat;
    private ?string $dateCreation;
    private bool $finish;
    private ?string $illustration;
    private bool $blocage;
    private ?string $motifBlocage;
    private ?string $dateBlocage;
    private bool $proccess;

    public function getId() : ?int{
        return $this->id;
    }

    public function setId(?int $id) : void{
        $this->id = $id;
    }

    public function getTitre() : ?string {
        return $this->titre;
    }

    public function setTitre(?string $titre) : void{
        $this->titre = $titre;
    }

    public function getTitreUrl(): ?string{
        return $this->titreUrl;
    }

    public function setTitreUrl(?string $titreUrl): void{
        $this->titreUrl = $titreUrl;
    }

    public function getDateDebut() : ?string {
        return $this->dateDebut;
    }

    public function setDateDebut(?string $dateDebut) : void{
        $this->dateDebut = $dateDebut;
    }

    public function getDateFin() : ?string {
        return $this->dateFin;
    }

    public function setDateFin(?string $dateFin) : void{
        $this->dateFin = $dateFin;
    }

    public function getDomaine() : Domaine {
        return $this->domaine;
    }

    public function setDomaine(Domaine $domaine) : void{
        $this->domaine = $domaine;
    }

    public function getClient() : Client {
        return $this->client;
    }

    public function setClient(Client $client) : void {
        $this->client = $client;
    }

    public function getLieu() : Lieu {
        return $this->lieu;
    }

    public function setLieu(Lieu $lieu) : void {
        $this->lieu = $lieu;
    }

    public function getDescription() : ?string {
        return $this->description;
    }

    public function setDescription(?string $description) : void{
        $this->description = $description;
    }

    public function getObjectif() : ?string {
        return $this->objectif;
    }

    public function setObjectif(?string $objectif) : void{
        $this->objectif = $objectif;
    }

    public function getResultat() : ?string {
        return $this->resultat;
    }

    public function setResultat(?string $resultat) : void{
        $this->resultat = $resultat;
    }

    public function getDateCreation() : ?string{
        return $this->dateCreation;
    }

    public function setDateCreation(?string $dateCreation) : void{
        $this->dateCreation = $dateCreation;
    }

    public function isFinish(): bool{
        return $this->finish;
    }

    public function setFinish(bool $finish): void{
        $this->finish = $finish;
    }

    public function getIllustration(): ?string{
        return $this->illustration;
    }

    public function setIllustration(?string $illustration): void{
        $this->illustration = $illustration;
    }

    public function isBlocage(): bool{
        return $this->blocage;
    }

    public function setBlocage(bool $blocage): void{
        $this->blocage = $blocage;
    }

    public function getMotifBlocage(): ?string{
        return $this->motifBlocage;
    }

    public function setMotifBlocage(?string $motifBlocage): void{
        $this->motifBlocage = $motifBlocage;
    }

    public function getDateBlocage(): ?string{
        return $this->dateBlocage;
    }

    public function setDateBlocage(?string $dateBlocage): void{
        $this->dateBlocage = $dateBlocage;
    }

    public function isProccess(): bool{
        return $this->proccess;
    }

    public function setProccess(bool $proccess): void{
        $this->proccess = $proccess;
    }

}

