<?php
namespace validation\admin\projets;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/ClientManager.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Functions.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Client.php");

use Exception;
use utils\Functions;
use src\Client;
use manager\ClientManager;

session_start();

if (($_SESSION ["utilisateur"]) == null) {
    echo json_encode(array(
        "type" => "session"
    ));
    exit();
}

$nomClient = Functions::getValueChamp($_POST["nom"]);

$clientManager = new ClientManager();
$erreurs = array();

try {
    Functions::validClientNon($clientManager, $nomClient, "nom du client", 2, 50);
} catch (Exception $e) {
    $erreurs["nom"] = $e->getMessage();
}

if(empty($erreurs)){
    
    $client = new Client();
    
    $client->setNom(ucfirst($nomClient));
    
    if($clientManager->addClient($client)){
        echo json_encode($clientManager->getAllClient());
    }
    
  
    
}else{
    echo json_encode($erreurs);
}