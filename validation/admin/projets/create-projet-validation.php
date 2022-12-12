<?php
namespace validation\admin\projets;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/ProjetManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Functions.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Client.php");

use Exception;
use utils\Functions;
use manager\ProjetManager;

session_start();

if (($_SESSION ["utilisateur"]) == null) {
    echo json_encode(array(
        "type" => "session"
    ));
    exit();
}

$titre = Functions::getValueChamp($_POST["titre"]);

$erreurs = array();
$projetManager = new ProjetManager();

try {
    Functions::validTitreProjet($projetManager, $titre, "titre du projet", 5, 80);
} catch (Exception $e) {
    $erreurs["titre"] = $e->getMessage();
}

if(empty($erreurs)){


    $projectId = $projetManager->createProjet(ucfirst($titre),Functions::formatUrl(strtolower($titre)));
    
    echo json_encode(array(
        "id" =>  $projectId
    ));
    
}else{
    echo json_encode($erreurs);
}