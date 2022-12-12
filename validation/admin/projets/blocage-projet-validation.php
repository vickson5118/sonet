<?php

namespace validation\admin\projets;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/ProjetManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Functions.php");

use DateTime;
use Exception;
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
$motif = Functions::getValueChamp($_POST["motif"]);

$erreurs = array();

if($id == null || intval($id) == 0){
    $erreurs["id"] = "Une erreur est survenue, veuillez réessayer ultérieurement.";
}

try {
    Functions::validTexte($motif, "motif", 10, 250, true);
}catch (Exception $e){
    $erreurs["motif"] = $e->getMessage();
}

if(empty($erreurs)){

    $projetManager = new ProjetManager();
    $projet = new Projet();

    $dateBlocage = new DateTime();
    $dateBlocage = $dateBlocage -> format("Y-m-d");

    $projet->setId(intval($id));
    $projet->setBlocage(true);
    $projet->setMotifBlocage(ucfirst($motif));
    $projet->setDateBlocage($dateBlocage);

    if($projetManager->bloquerAndDebloquerProjet($projet)){
        echo json_encode(array(
            "type" => "success"
        ));
    }

}else{
    echo json_encode($erreurs);
}
