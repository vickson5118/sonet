<?php
namespace validation\admin\projets;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/ProjetManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Functions.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Projet.php");

use manager\ProjetManager;

session_start();

if (($_SESSION ["utilisateur"]) == null) {
    echo json_encode(array(
        "type" => "session"
    ));
    exit();
}


$resultat = $_POST["resultat"];

$projetManager = new ProjetManager();

$projetManager->updateResultat($resultat, $_SESSION["projet"]->getId());