<?php
namespace manager;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/Database.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Functions.php");

use Exception;
use utils\Functions;
use utils\Constants;
use src\Domaine;

class DomaineManager{

    /**
     * Ajouter un domaine
     * @param Domaine $domaine
     * @return bool
     */
    public function addDomaine(Domaine $domaine): bool {
        try {
            $bdd = Database::getInstance();
            $sql = "INSERT INTO " . Constants::TABLE_DOMAINE . "(nom) VALUES(?)";

            $prepare = Functions::bindPrepare($bdd, $sql, $domaine->getNom());
            return $prepare->execute();
        } catch (Exception $e) {
            die("Une erreur est survenue : " . $e->getMessage());
        } finally{
            $prepare->closeCursor();
        }
    }

    /**
     * Obtenir la liste de tous les domaines enregistrés
     *
     * @return array
     */
    public function getAllDomaine(): array{
        try {
            $bdd = Database::getInstance();
            $sql = "SELECT id, nom FROM " . Constants::TABLE_DOMAINE . " ORDER BY id";

            $prepare = Functions::bindPrepare($bdd, $sql);
            $prepare->execute();

            $listeDomaine = array();

            while ($result = $prepare->fetch()) {
                $domaine = new Domaine();
                
                $domaine->setId($result["id"]);
                $domaine->setNom($result["nom"]);
                
                $listeDomaine[] = $domaine;
                
            }
            
            return $listeDomaine;
        } catch (Exception $e) {
            die("Une erreur est survenue : " . $e->getMessage());
        } finally{
            $prepare->closeCursor();
        }
    }

    /**
     * Verife que le domaine existe deja
     * @param string|null $nom
     * @return bool
     */
    public function domaineExist(?string $nom) : bool{
        try {
                    
        	$bdd = Database::getInstance ();
        	$sql = "SELECT id FROM ".Constants::TABLE_DOMAINE." WHERE nom=?";
        	
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
     * Verife que l'ID du domaine existe deja
     * @param int|null $id
     * @return bool
     */
    public function domaineIdExist(?int $id) : bool{
        try {
            
            $bdd = Database::getInstance ();
            $sql = "SELECT nom FROM ".Constants::TABLE_DOMAINE." WHERE id=?";
            
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

