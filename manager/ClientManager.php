<?php
namespace manager;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/Database.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Functions.php");

use Exception;
use src\Client;
use utils\Functions;
use utils\Constants;

class ClientManager{

    /**
     * Ajouter un client
     * @param Client $client
     * @return bool
     */
    public function addClient(Client $client) : bool {
        try {
            $bdd = Database::getInstance();
            $sql = "INSERT INTO " . Constants::TABLE_CLIENT . "(nom) VALUES(?)";

            $prepare = Functions::bindPrepare($bdd, $sql, $client->getNom());
            return $prepare->execute();
        } catch (Exception $e) {
            die("Une erreur est survenue : " . $e->getMessage());
        } finally{
            $prepare->closeCursor();
        }
    }

    /**
     * Obtenir la liste de tous les clients enregistrés
     *
     * @return array
     */
    public function getAllClient(): array{
        try {
            $bdd = Database::getInstance();
            $sql = "SELECT id, nom FROM " . Constants::TABLE_CLIENT . " ORDER BY id";

            $prepare = Functions::bindPrepare($bdd, $sql);
            $prepare->execute();

            $listeClient = array();

            while ($result = $prepare->fetch()) {
                $client = new Client();
                
                $client->setId($result["id"]);
                $client->setNom($result["nom"]);
                
                $listeClient[] = $client;
                
            }
            
            return $listeClient;
        } catch (Exception $e) {
            die("Une erreur est survenue : " . $e->getMessage());
        } finally{
            $prepare->closeCursor();
        }
    }

    /**
     * Vérifier qu'un client existe
     * @param string|null $nom
     * @return bool
     */
    public function clientExist(?string $nom) : bool{
        try {
                    
        	$bdd = Database::getInstance ();
        	$sql = "SELECT id FROM ".Constants::TABLE_CLIENT." WHERE nom=?";
        	
        	$prepare = Functions::bindPrepare ( $bdd, $sql, $nom);
        	$prepare->execute ();
        	$result = $prepare->fetch ();
        	
        	if(empty($result)){
        	    return false;
        	}
        	
        	return true;
             
        } catch ( Exception $e ) {  
        	die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
        	$prepare->closeCursor ();
         }
    }

    /**
     * Vérifier que l'ID du client existe
     * @param int|null $id
     * @return bool
     */
    public function clientIdExist(?int $id) : bool{
        try {
            
            $bdd = Database::getInstance ();
            $sql = "SELECT nom FROM ".Constants::TABLE_CLIENT." WHERE id=?";
            
            $prepare = Functions::bindPrepare ( $bdd, $sql, $id);
            $prepare->execute ();
            $result = $prepare->fetch ();
            
            if(empty($result)){
                return false;
            }
            
            return true;
            
        } catch ( Exception $e ) {
            die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
            $prepare->closeCursor ();
        }
    }
}

