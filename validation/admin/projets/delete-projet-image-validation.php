<?php

namespace validation\admin\projets;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/FileManager.php");

use utils\Functions;
use manager\FileManager;

session_start();

if (($_SESSION ["utilisateur"]) == null) {
    echo json_encode(array(
        "type" => "session"
    ));
    exit();
}

$chemin = Functions::getValueChamp($_POST["chemin"]);

$fileManager = new FileManager();

if($fileManager->deleteOneFile($chemin)){
    unlink($_SERVER["DOCUMENT_ROOT"].$chemin);
    echo json_encode(array(
        "type" => "success"
    ));
}