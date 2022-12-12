<?php

namespace validation\admin\projets;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/ProjetManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/ClientManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/DomaineManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/LieuManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Projet.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Domaine.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Client.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Lieu.php");

use Exception;
use DateTime;
use utils\Constants;
use utils\Functions;
use manager\ProjetManager;
use manager\ClientManager;
use manager\DomaineManager;
use manager\LieuManager;
use src\Projet;
use src\Domaine;
use src\Client;
use src\Lieu;

session_start();

if (($_SESSION ["utilisateur"]) == null) {
    echo json_encode(array(
        "type" => "session"
    ));
    exit();
}

$titre = Functions::getValueChamp($_POST["titre"]);
$clientId = Functions::getValueChamp($_POST["client"]);
$domaineId = Functions::getValueChamp($_POST["domaine"]);
$lieuId = Functions::getValueChamp($_POST["lieu"]);
$dateDebut = Functions::getValueChamp($_POST["debut"]);
$dateFin = Functions::getValueChamp($_POST["fin"]);
$description = Functions::getValueChamp($_POST["description"]);
$objectif = Functions::getValueChamp($_POST["objectif"]);
$resultat = Functions::getValueChamp($_POST["resultat"]);
$achievement = Functions::getValueChamp($_POST["achievement"]);
$projetIllustration = $_FILES["illustration"];

$projetManager = new ProjetManager();
$clientManager = new ClientManager();
$domaineManager = new DomaineManager();
$lieuManager = new LieuManager();

$erreurs = array();

try {
    Functions::validTitreProjetExist($projetManager, $titre, $_SESSION["projet"]->getId(), "titre du projet", 5, 80);
} catch (Exception $e) {
    $erreurs["titre"] = $e->getMessage();
}

if(!$clientManager->clientIdExist(intval($clientId))){
    $erreurs["client"] = "Le client que vous avez choisi n'existe pas.";
}

if(!$domaineManager->domaineIdExist(intval($domaineId))){
    $erreurs["domaine"] = "Le domaine que vous avez choisi n'existe pas.";
}

if(!$lieuManager->lieuIdExist(intval($lieuId))){
    $erreurs["lieu"] = "Le lieu que vous avez choisi n'existe pas.";
}

if(empty(strip_tags($description))){
    $erreurs["description"] = "Le champ description du projet ne peut être vide.";
}

if(empty(strip_tags($objectif))){
    $erreurs["objectif"] = "Le champ objectifs du projet ne peut être vide.";
}

if(empty(strip_tags($resultat))){
    $erreurs["resultat"] = "Le champ resultats du projet ne peut être vide.";
}

try{
    Functions::validDate($dateDebut, false);
} catch(Exception $e){
    $erreurs["debut"] = $e -> getMessage();
}

try{
    if($dateFin != null || intval($achievement) == 1){
        Functions::validDate($dateFin,true);
        $dateDebutConvert = new DateTime(Functions::convertDateFrToEn($dateDebut));
        $dateFinConvert = new DateTime(Functions::convertDateFrToEn($dateFin));

        if($dateDebutConvert >= $dateFinConvert){
            throw new Exception("La date de fin du projet ne peut être antérieur à la date de début du projet.");
        }
    }
} catch(Exception $e){
    $erreurs["fin"] = $e -> getMessage();
}

if(empty($erreurs)){

    $dateCreation = new DateTime();
    $dateCreation = $dateCreation->format("Y-m-d");

    $projet = new Projet();
    $domaine = new Domaine();
    $client = new Client();
    $lieu = new Lieu();

    $domaine->setId(intval($domaineId));

    $client->setId(intval($clientId));

    $lieu->setId(intval($lieuId));

    $projet->setId($_SESSION["projet"]->getId());
    $projet->setTitre(ucfirst($titre));
    $projet->setTitreUrl(Functions::formatUrl(strtolower($titre)));
    $projet->setDateDebut(Functions::convertDateFrToEn($dateDebut));
    $projet->setDateFin(Functions::convertDateFrToEn($dateFin));
    $projet->setDateCreation($dateCreation);
    $projet->setDescription($description);
    $projet->setObjectif($objectif);
    $projet->setResultat($resultat);
    $projet->setClient($client);
    $projet->setDomaine($domaine);
    $projet->setLieu($lieu);
    $projet->setProccess(false);

    if(intval($achievement) == 1) {

        $projet->setFinish(true);

    }else
        $projet->setFinish(0);

    if(!empty($projetIllustration["name"])){
        try {
            $extension = Functions::validImage($projetIllustration,10000000,"10Mo",1920,900);
        }catch(Exception $e){
            $erreurs["illustration"] = $e->getMessage();
            echo json_encode($erreurs);
            exit();
        }

        if($_SESSION["projet"]->getIllustration() != null){
            unlink($_SERVER["DOCUMENT_ROOT"].$_SESSION["projet"]->getIllustration());
        }

        $folderDestination = $_SERVER["DOCUMENT_ROOT"].Constants::PROJET_ILLUSTATION_FOLDER.$projet->getId().".".$extension;
        $projet->setIllustration(Constants::PROJET_ILLUSTATION_FOLDER.$projet->getId().".".$extension);

        move_uploaded_file($projetIllustration["tmp_name"],$folderDestination);
        $projetManager->addProjet($projet, true);
        unset($_SESSION["projet"]);
        echo json_encode(array(
            "type" => "success"
        ));
    }else if($_SESSION["projet"] -> getIllustration() == null){
        $erreurs["illustration"] = "L'image d'illustration du projet est inexistant.";
        echo json_encode($erreurs);
        exit();
    }else{
        $projetManager->addProjet($projet, false);
        echo json_encode(array(
            "type" => "success"
        ));
    }
}else{
    echo json_encode($erreurs);
}


