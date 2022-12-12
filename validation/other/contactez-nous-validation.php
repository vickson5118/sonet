<?php
namespace validation\other;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/ContactManager.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/Contact.php");

use DateTime;
use Exception;
use manager\ContactManager;
use src\Contact;
use utils\Functions;


$nom = Functions::getValueChamp($_POST["nom"]);
$prenoms = Functions::getValueChamp($_POST["prenoms"]);
$email = Functions::getValueChamp($_POST["email"]);
$telephone = Functions::getValueChamp($_POST["telephone"]);
$objet = Functions::getValueChamp($_POST["objet"]);
$message = Functions::getValueChamp($_POST["message"]);

$erreurs = array();

try {
    Functions::validTexte($nom, "nom", 2, 15, true);
} catch ( Exception $e ) {
    $erreurs["nom"] = $e->getMessage();
}

try {
    Functions::validTexte($prenoms, "prenoms", 2, 30, true);
} catch ( Exception $e ) {
    $erreurs["prenoms"] = $e->getMessage();
}

try {
    Functions::validContactEmail($email);
} catch ( Exception $e ) {
    $erreurs["email"] = $e->getMessage();
}

try {
    Functions::validTelephone($telephone);
} catch ( Exception $e ) {
    $erreurs["telephone"] = $e->getMessage();
}

try {
    Functions::validTexte($objet, "objet", 10, 100, true);
} catch ( Exception $e ) {
    $erreurs["objet"] = $e->getMessage();
}

try {
    Functions::validTexte($message, "message", 50, 1000, true);
} catch ( Exception $e ) {
    $erreurs["message"] = $e->getMessage();
}

if ( empty($erreurs) ) {

        $contactManager = new ContactManager();
        $contact = new Contact();
        
        $dateEnvoi = new DateTime();
        $dateEnvoi = $dateEnvoi->format("Y-m-d");
        
        $contact->setNom(ucfirst(strtolower($nom)));
        $contact->setPrenoms(ucwords(strtolower($prenoms)));
        $contact->setEmail($email);
        $contact->setTelephone($telephone);
        $contact->setObjet(ucfirst($objet));
        $contact->setMessage(ucfirst($message));
        $contact->setDateEnvoi($dateEnvoi);

        if($contactManager->addContact($contact)) {
            echo json_encode(array("type" => "success"));
        }

} else {
    echo json_encode($erreurs);
}





