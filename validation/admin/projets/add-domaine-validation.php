<?php
namespace validation\admin\projets;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/DomaineManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Functions.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Domaine.php");

use Exception;
use utils\Functions;
use src\Domaine;
use manager\DomaineManager;

session_start();

if (($_SESSION ["utilisateur"]) == null) {
    echo json_encode(array(
        "type" => "session"
    ));
    exit();
}

$nomDomaine = Functions::getValueChamp($_POST["nom"]);

$domaineManager = new DomaineManager();
$erreurs = array();

try {
    Functions::validDomaineNon($domaineManager, $nomDomaine, "nom du domaine", 2, 30);
} catch (Exception $e) {
    $erreurs["nom"] = $e->getMessage();
}

if(empty($erreurs)){
    
   
    $domaine = new Domaine();
    
    $domaine->setNom(ucfirst($nomDomaine));
    
    if($domaineManager->addDomaine($domaine)){
        echo json_encode($domaineManager->getAllDomaine());
    }
    
    
}else{
    echo json_encode($erreurs);
}