<?php

namespace validation\admin\compte;

require_once($_SERVER["DOCUMENT_ROOT"]."/manager/UtilisateurManager.php");

use manager\UtilisateurManager;
use utils\Constants;


$email = strip_tags(trim($_POST["email"]));
$password = strip_tags(trim($_POST["password"]));

$password = Constants::PASSWORD_GENERATE_START_SALT . $password . Constants::PASSWORD_GENERATE_END_SALT;

$utilisateurManager = new UtilisateurManager();

$utilisateur = $utilisateurManager -> connexion($email);

if($utilisateur != null && password_verify($password, $utilisateur->getPassword())){
    
    if($utilisateur->getBloquer()){
        echo json_encode(array(
            "error" => "Votre compte a été bloqué par ".Constants::ENTREPRISE_NAME
        ));
        exit();
    }
    
    session_start ();
    $_SESSION ["utilisateur"] = $utilisateur;
    
    $utilisateurManager->updateConnect(true,$utilisateur->getId());
    
    echo json_encode(array(
        "type" => "success"
    ));
    
}else{
    
    echo json_encode(array(
        "error" => "L'adresse E-mail et/ou le mot de passe est incorrect"
    ));
    
}