<?php

namespace validation\admin\projets;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Constants.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/FileManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/File.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Projet.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Client.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Domaine.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Lieu.php");

use utils\Constants;
use manager\FileManager;
use src\File;
use src\Projet;

session_start();


$folderDownloadDestination = $_SERVER["DOCUMENT_ROOT"].Constants::PROJET_FILES_FOLDER;
$folderDestination = Constants::PROJET_FILES_FOLDER;

if(isset($_FILES["myfile"])){
    
    $fileManager = new FileManager();
    //$ret = array();

    //$error =$_FILES["myfile"]["error"];
    
    if(!is_array($_FILES["myfile"]["name"])) {
        
        $file = new File();
        $projet = new Projet();
        
        $extension = strtolower(pathinfo($_FILES["myfile"]["name"],PATHINFO_EXTENSION));
        
        $fileName = microtime().".".$extension;
        $chemin = $folderDestination.$fileName;
        $cheminDownload = $folderDownloadDestination.$fileName;
        
        $projet->setId($_SESSION["projet"]->getId());
        
        $file->setProjet($projet);
        $file->setChemin($chemin);
        
        $fileManager->addFile($file);
        
        move_uploaded_file($_FILES["myfile"]["tmp_name"],$cheminDownload);
        //$ret[]= $fileName;
    } else {
        $fileCount = count($_FILES["myfile"]["name"]);
        for($i=0; $i < $fileCount; $i++){
            $file = new File();
            $projet = new Projet();
            
            $extension = strtolower(pathinfo($_FILES["myfile"]["name"],PATHINFO_EXTENSION));
            
            $fileName = microtime().$extension;
            $chemin = $folderDestination.$fileName;
            $cheminDownload = $folderDownloadDestination.$fileName;
            
            $projet->setId($_SESSION["projet"]->getId());
            
            $file->setProjet($projet);
            $file->setChemin($chemin);
            
            $fileManager->addFile($file);
            
            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$cheminDownload);
            //$ret[]= $fileName;
        }
        
    }
    //echo json_encode($ret);
}