<?php

namespace manager;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/Database.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Utilisateur.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/Functions.php");

use Exception;
use src\Utilisateur;
use utils\Constants;
use utils\Functions;

class UtilisateurManager{

    /**
     * Recuperer tous les utilisateurs de la base de données soit admin soit standard
     * @param int $typeComte
     * @return array
     */
    public function getAllUser(int $typeComte): array{
        try {
        	$bdd = Database::getInstance();
        	
        	$sql = "SELECT id, nom, prenoms, email, date_inscription, bloquer, motif_blocage, date_blocage,connect FROM ".Constants::TABLE_UTILISATEUR." WHERE type_compte=?";
                    
        	$prepare = Functions::bindPrepare($bdd, $sql, $typeComte);
        	$prepare->execute();
        	
        	$listeUtilisateur = array();
        	
        	while($result = $prepare->fetch()){
        	    
        	    $utilisateur = new Utilisateur();
        	    
        	    $utilisateur->setId($result["id"]);
        	    $utilisateur->setNom($result["nom"]);
        	    $utilisateur->setPrenoms($result["prenoms"]);
        	    $utilisateur->setEmail($result["email"]);
        	    $utilisateur->setDateInscription(Functions::convertDateEnToFr($result["date_inscription"]));
        	    $utilisateur->setBloquer($result["bloquer"]);
        	    $utilisateur->setMotifBlocage($result["motif_blocage"]);
        	    $utilisateur->setDateBlocage(Functions::convertDateEnToFr($result["date_blocage"]));
        	    $utilisateur->setConnect($result["connect"]);
        	    
        	    $listeUtilisateur[] = $utilisateur;
        	}
        	
        	return $listeUtilisateur;
        
        } catch (Exception $e) {
        	die("Une erreur est survenue : ".$e->getMessage());
        }finally{
        	$prepare->closeCursor();
        }
    }
    
    /**
     * Verifie si une adresse email existe en base de données
     *
     * @param string $email
     * @return bool
     */
    public function emailExist(string $email): bool {
        try {
            
            $bdd = Database::getInstance ();
            $sql = "SELECT id FROM " . Constants::TABLE_UTILISATEUR . " WHERE email=?";
            
            $prepare = Functions::bindPrepare ( $bdd, $sql,$email);
            $prepare->execute ();
            $result = $prepare->fetch ();
            
            if (empty ( $result )) {
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
     * Enregistrer un utilisateur en base de données
     * @param Utilisateur $utilisateur
     * @return int
     */
    public function addAdmin(Utilisateur $utilisateur): int {
        try {
            $bdd = Database::getInstance ();
            
                $sql = "INSERT INTO " . Constants::TABLE_UTILISATEUR . "(nom,prenoms,email,password,type_compte,date_inscription) VALUES(?,?,?,?,?,?)";
                
                $prepare = Functions::bindPrepare ( $bdd, $sql,
                    $utilisateur->getNom (),
                    $utilisateur->getPrenoms (),
                    $utilisateur->getEmail (),
                    $utilisateur->getPassword (),
                    $utilisateur->getTypeCompte(),
                    $utilisateur->getDateInscription(),
                    );
            
            $prepare->execute ();
            return $bdd->lastInsertId();
            
        } catch ( Exception $e ) {
            
            die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
            $prepare->closeCursor ();
        }
    }

    /**
     * Verifie l'adresse Email et le mot de passe pour connecter l'utilisateur ou le Token
     * @param string|null $email
     * @return Utilisateur
     */
    public function connexion(?string $email): ?Utilisateur{
        try {
            $bdd = Database::getInstance ();

            $sql = "SELECT id,nom,prenoms,password,email,date_inscription,type_compte, bloquer FROM " . Constants::TABLE_UTILISATEUR  . " WHERE email=?";
            
            $prepare = Functions::bindPrepare ( $bdd, $sql, $email);
            $prepare->execute ();
            
            $utilisateur = null;
            
            while ( $result = $prepare->fetch () ) {
                
                $utilisateur = new Utilisateur ();
                
                $utilisateur->setId ( $result ["id"] );
                $utilisateur->setNom ( $result ["nom"] );
                $utilisateur->setPrenoms ( $result ["prenoms"] );
                $utilisateur->setEmail ( $result ["email"] );
                $utilisateur->setPassword($result["password"]);
                $utilisateur->setDateInscription(Functions::convertDateEnToFr($result["date_inscription"]));
                $utilisateur->setTypeCompte($result["type_compte"]);
                $utilisateur->setBloquer($result["bloquer"]);
            }
            
            return $utilisateur;
        } catch ( Exception $e ) {
            die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally{
            $prepare->closeCursor ();
        }
    }

    /**
     * Mettre a jour le champ connect
     * @param bool $connectStatus
     * @param int $id
     */
    public function updateConnect(bool $connectStatus,int $id): void{
        try {
            
            $bdd = Database::getInstance();
            $sql = "UPDATE ".Constants::TABLE_UTILISATEUR." SET connect=? WHERE id=?";
            $prepare = Functions::bindPrepare($bdd, $sql,$connectStatus, $id);
            
            $prepare->execute();
            
        } catch (Exception $e) {
            die ( "Une erreur est survenue -> " . $e->getMessage () );
        }finally {
            $prepare->closeCursor();
        }
    }
    
    /**
     * Deconnecter un utilisateur en BDD
     * @param int $id
     * @return bool
     */
    public function deconnexion(int $id): bool{
        try {
            
            $bdd = Database::getInstance();
            $sql = "UPDATE ".Constants::TABLE_UTILISATEUR." SET connect=false WHERE id=?";
            $prepare = Functions::bindPrepare($bdd, $sql,$id);
            
            return $prepare->execute();
            
        } catch (Exception $e) {
            die ( "Une erreur est survenue -> " . $e->getMessage () );
        }finally {
            $prepare->closeCursor();
        }
    }

    /**
     * Bloquer ou debloquer un utilisateur
     * @param Utilisateur $utilisateur
     * @param bool $isLocked
     * @return bool
     */
    public function bloquerAndDebloquer(Utilisateur $utilisateur, bool $isLocked): bool{
        try {
            $bdd = Database::getInstance();
            
            if($isLocked){
                $sql = "UPDATE ".Constants::TABLE_UTILISATEUR." SET bloquer=?,motif_blocage=?,date_blocage=? WHERE id=?";
                $prepare = Functions::bindPrepare($bdd, $sql,
                    $utilisateur->getBloquer(),
                    $utilisateur->getMotifBlocage(),
                    $utilisateur->getDateBlocage(),
                    $utilisateur->getId()
                    );
            }else{
                $sql = "UPDATE ".Constants::TABLE_UTILISATEUR." SET bloquer=false,motif_blocage=?,date_blocage=? WHERE id=?";
                $prepare = Functions::bindPrepare($bdd, $sql,
                    $utilisateur->getMotifBlocage(),
                    $utilisateur->getDateBlocage(),
                    $utilisateur->getId()
                    );
            }
            
            return $prepare->execute();
            
        } catch (Exception $e) {
            die("Une erreur est survenue : ".$e->getMessage());
        }finally{
            $prepare->closeCursor();
        }
    }

}

