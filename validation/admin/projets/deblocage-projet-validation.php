<?php

namespace validation\admin\projets;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/ProjetManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Functions.php");

use manager\ProjetManager;
use src\Projet;
use utils\Functions;

session_start();

if (($_SESSION ["utilisateur"]) == null) {
    echo json_encode(array(
        "type" => "session"
    ));
    exit();
}

$id = Functions::getValueChamp($_POST["id"]);

$erreurs = array();

if($id == null || intval($id) == 0){
    $erreurs["id"] = "Une erreur est survenue, veuillez réessayer ultérieurement.";
}

if(empty($erreurs)){

    $projetManager = new ProjetManager();
    $projet = new Projet();

    $projet->setId(intval($id));
    $projet->setMotifBlocage(null);
    $projet->setDateBlocage(null);
    $projet->setBlocage(false);

    if($projetManager->bloquerAndDebloquerProjet($projet)){
        echo json_encode(array(
            "type" => "success"
        ));
    }

}else{
    echo json_encode($erreurs);
}
