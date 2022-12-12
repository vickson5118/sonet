<?php
namespace manager;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/Database.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Functions.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/File.php");

use Exception;
use src\File;
use utils\Constants;
use utils\Functions;

class FileManager{
    
    /**
     * Ajouter un nouveau fichier au projet
     * @param File $file
     */
    public function addFile(File $file){
        try {
                    
        	$bdd = Database::getInstance ();
        	$sql = "INSERT INTO ".Constants::TABLE_FILE."(projet_id,chemin) VALUES(?,?)";
                    
        	$prepare = Functions::bindPrepare ( $bdd, $sql,$file->getProjet()->getId(),$file->getChemin());
        	$prepare->execute ();
             
        } catch ( Exception $e ) {  
        	die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
        	$prepare->closeCursor ();
         }
    }

    /**
     * Obtenir les images d'un projet
     * @param int|null $projetId
     * @return array
     */
    public function getProjetFiles(?int $projetId) : array{
        try {
                    
        	$bdd = Database::getInstance ();
        	$sql = "SELECT id,chemin FROM ".Constants::TABLE_FILE." WHERE projet_id=?";
                    
        	$prepare = Functions::bindPrepare ( $bdd, $sql,$projetId);
        	$prepare->execute ();
            
        	$listeFile = array();
        	
        	while ($result = $prepare->fetch ()) {
        	    $file = new File();
        	    
        	    $file->setId($result["id"]);
        	    $file->setChemin($result["chemin"]);
        	    
        	    $listeFile[] = $file;
        	}
             
            return $listeFile;        	
        	
        } catch ( Exception $e ) {  
        	die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
        	$prepare->closeCursor ();
         }
    }

    /**
     * Supprimer un ficher de la BDD
     * @param String|null $chemin
     * @return bool
     */
    public function deleteOneFile(?String $chemin) : bool{
        
        if($chemin == NULL){
            return false;
        }
        
        try {
                    
        	$bdd = Database::getInstance ();
        	$sql = "DELETE FROM ".Constants::TABLE_FILE." WHERE chemin=?";
                    
        	$prepare = Functions::bindPrepare ( $bdd, $sql,$chemin);
        	return $prepare->execute ();
             
        } catch ( Exception $e ) {  
        	die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
        	$prepare->closeCursor ();
         }
    }
    
}

