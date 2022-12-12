<?php
namespace validation\admin\projets;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/LieuManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Functions.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Lieu.php");

use Exception;
use utils\Functions;
use manager\LieuManager;
use src\Lieu;

session_start();

if (($_SESSION ["utilisateur"]) == null) {
    echo json_encode(array(
        "type" => "session"
    ));
    exit();
}

$nomLieu = Functions::getValueChamp($_POST["nom"]);

$lieuManager = new LieuManager();
$erreurs = array();

try {
    Functions::validLieuNon($lieuManager, $nomLieu, "nom du lieu", 2, 20);
} catch (Exception $e) {
    $erreurs["nom"] = $e->getMessage();
}

if(empty($erreurs)){
    
    $lieu = new Lieu();
    
    $lieu->setNom(ucfirst($nomLieu));
    
    if($lieuManager->addLieu($lieu)){
        echo json_encode($lieuManager->getAllLieu());
    }
    
    
    
}else{
    echo json_encode($erreurs);
}