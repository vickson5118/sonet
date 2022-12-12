<?php
namespace manager;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/Database.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Functions.php");

use Exception;
use src\Lieu;
use utils\Functions;
use utils\Constants;

class LieuManager{

    /**
     * Ajouter un lieu
     * @param Lieu $lieu
     * @return bool
     */
    public function addLieu(Lieu $lieu): bool {
        try {
            $bdd = Database::getInstance();
            $sql = "INSERT INTO " . Constants::TABLE_LIEU . "(nom) VALUES(?)";

            $prepare = Functions::bindPrepare($bdd, $sql, $lieu->getNom());
            return $prepare->execute();
        } catch (Exception $e) {
            die("Une erreur est survenue : " . $e->getMessage());
        } finally{
            $prepare->closeCursor();
        }
    }

    /**
     * Obtenir la liste de tous les lieux enregistrés
     *
     * @return array
     */
    public function getAllLieu(): array{
        try {
            $bdd = Database::getInstance();
            $sql = "SELECT id, nom FROM " . Constants::TABLE_LIEU . " ORDER BY id";

            $prepare = Functions::bindPrepare($bdd, $sql);
            $prepare->execute();

            $listeLieu = array();

            while ($result = $prepare->fetch()) {
                $lieu = new Lieu();
                
                $lieu->setId($result["id"]);
                $lieu->setNom($result["nom"]);
                
                $listeLieu[] = $lieu;
                
            }
            
            return $listeLieu;
        } catch (Exception $e) {
            die("Une erreur est survenue : " . $e->getMessage());
        } finally{
            $prepare->closeCursor();
        }
    }

    /**
     * Verifier que le lieu existe
     * @param string|null $nom
     * @return bool
     */
    public function lieuExist(?string $nom) : bool{
        try {
                    
        	$bdd = Database::getInstance ();
        	$sql = "SELECT id FROM ".Constants::TABLE_LIEU." WHERE nom=?";
        	
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
     * Verifier que l'Id du lieu existe
     * @param int|null $id
     * @return bool
     */
    public function lieuIdExist(?int $id) : bool{
        try {
            
            $bdd = Database::getInstance ();
            $sql = "SELECT nom FROM ".Constants::TABLE_LIEU." WHERE id=?";
            
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

