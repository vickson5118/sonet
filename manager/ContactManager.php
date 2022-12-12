<?php
namespace manager;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Contact.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/Database.php");

use Exception;
use src\Contact;
use utils\Constants;
use utils\Functions;

class ContactManager {

    /**
     * Envoyer un mail pour un particulier
     * @param Contact $contact
     * @return bool
     */
    public function addContact(Contact $contact): bool {
        try {
            $bdd = Database::getInstance();
            $sql = "INSERT INTO " . Constants::TABLE_CONTACT . "(nom,prenoms,telephone,email,objet,message,date_envoi) VALUES (?,?,?,?,?,?,?)";
            $prepare = Functions::bindPrepare($bdd, $sql,
                $contact->getNom(),
                $contact->getPrenoms(),
                $contact->getTelephone(),
                $contact->getEmail(),
                $contact->getObjet(),
                $contact->getMessage(),
                $contact->getDateEnvoi()
            );

            return $prepare->execute();
        } catch ( Exception $e ) {
            die("Une erreur est survenue -> " . $e->getMessage());
        } finally {
            $prepare->closeCursor();
        }
    }

    /**
     * Lire le mail
     * @param int $contactId
     * @return Contact
     */
    public function getMail(int $contactId): ?Contact{
        try {
        	$bdd = Database::getInstance();
        	$sql = "SELECT id,nom,prenoms,email,telephone,objet,message,date_envoi,view FROM ".Constants::TABLE_CONTACT." WHERE id=?";
                    
        	$prepare = Functions::bindPrepare($bdd, $sql, $contactId);
        	$prepare->execute();
        	
        	$contact = null;
        	while ($result = $prepare->fetch()) {
        	    $contact = new Contact();

                $contact->setId($result["id"]);
        	    $contact->setNom($result["nom"]);
        	    $contact->setPrenoms($result["prenoms"]);
        	    $contact->setEmail($result["email"]);
        	    $contact->setTelephone($result["telephone"]);
        	    $contact->setObjet($result["objet"]);
        	    $contact->setMessage($result["message"]);
        	    $contact->setDateEnvoi(Functions::convertDateEnToFr($result["date_envoi"]));
                $contact->setView($result["view"]);
        	}
        
        	return $contact;
        	
        } catch (Exception $e) {
        	die("Une erreur est survenue : ".$e->getMessage());
        }finally{
        	$prepare->closeCursor();
        }
    }
    
    /**
     * Mise a jour de la lecture du mail
     * @param int $id
     */
    public function updateView(int $id): void{
        try {
        	$bdd = Database::getInstance();
        	$sql = "UPDATE ".Constants::TABLE_CONTACT." SET view=true WHERE id=?";
                    
        	$prepare = Functions::bindPrepare($bdd, $sql, $id);
        	$prepare->execute();
        
        } catch (Exception $e) {
        	die("Une erreur est survenue : ".$e->getMessage());
        }finally{
        	$prepare->closeCursor();
        }
    }
    
    /**
     * Verifier s'il y a des mails non lus en BDD
     * @return bool
     */
    public function isNotView(): bool{
        try {
        	$bdd = Database::getInstance();
        	$sql = "SELECT id FROM ".Constants::TABLE_CONTACT." WHERE view=false";
                    
        	$prepare = Functions::bindPrepare($bdd, $sql);
        	$prepare->execute();
        	
        	if(!empty($prepare->fetch())){
        	    return true;
        	}
            return false;
        } catch (Exception $e) {
        	die("Une erreur est survenue : ".$e->getMessage());
        }finally{
        	$prepare->closeCursor();
        }
    }

    /** Retourne la liste des contacts
     * @return array
     */
    public function getAllContact() : array{
        try {

            $bdd = Database::getInstance ();
            $sql = "SELECT id,nom,prenoms,email,telephone,objet,message,date_envoi,view FROM ".Constants::TABLE_CONTACT;

            $prepare = Functions::bindPrepare ($bdd, $sql);
            $prepare->execute();

            $listeContact = array();

            while($result = $prepare->fetch()){
                $contact = new Contact();

                $contact->setId($result["id"]);
                $contact->setNom($result["nom"]);
                $contact->setPrenoms($result["prenoms"]);
                $contact->setEmail($result["email"]);
                $contact->setTelephone($result["telephone"]);
                $contact->setObjet($result["objet"]);
                $contact->setMessage($result["message"]);
                $contact->setDateEnvoi(Functions::convertDateEnToFr($result["date_envoi"]));
                $contact->setView($result["view"]);

                $listeContact[] = $contact;
            }

            return $listeContact;
        } catch ( Exception $e ) {
            die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
            $prepare->closeCursor ();
        }
    }
    
}





