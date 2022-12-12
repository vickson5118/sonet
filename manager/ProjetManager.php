<?php
namespace manager;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/manager/Database.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Functions.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Projet.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Domaine.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Client.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/src/Lieu.php");

use Exception;
use utils\Constants;
use utils\Functions;
use src\Projet;
use src\Domaine;
use src\Client;
use src\Lieu;

class ProjetManager{

    /**
     * Ajouter un nouveau projet en inserant le titre
     * @param string|null $titre
     * @param string|null $titreUrl
     * @return int|NULL
     */
    public function createProjet(?string $titre, ?string $titreUrl) : ?int {
        try {
            
            $bdd = Database::getInstance ();
            $sql = "INSERT INTO ".Constants::TABLE_PROJET."(titre, titre_url) VALUES(?,?)";
            
            $prepare = Functions::bindPrepare ( $bdd, $sql, $titre,$titreUrl);
            $prepare->execute ();
            
           return $bdd->lastInsertId();
            
        } catch ( Exception $e ) {
            die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
            $prepare->closeCursor ();
        }
    }

    /**
     * Verifie que le titre du projet en cours de creation n'existe pas déja en BDD
     * @param string|null $titre
     * @return bool
     */
    public function projetExist(?string $titre): bool{
        try {
                    
        	$bdd = Database::getInstance ();
        	$sql = "SELECT id FROM ".Constants::TABLE_PROJET." WHERE titre=?";
                    
        	$prepare = Functions::bindPrepare ( $bdd, $sql, $titre);
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
     * Verifie que le titre du projet en cours de creation n'existe pas déja en BDD
     * @param string|null $titre
     * @param int $id
     * @return bool
     */
    public function projetTitreExist(?string $titre, int $id): bool{
        try {
            
            $bdd = Database::getInstance ();
            $sql = "SELECT id FROM ".Constants::TABLE_PROJET." WHERE titre=? AND id!=?";
            
            $prepare = Functions::bindPrepare ( $bdd, $sql, $titre,$id);
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
     * Obtenir le projet avec l'id
     * @param int|null $id
     * @return Projet
     */
    public function getOneProjet(?int $id): ?Projet{
        try {
                    
        	$bdd = Database::getInstance ();
        	$sql = "SELECT id,titre,date_debut,date_debut,date_fin,domaine_id,lieu_id,client_id,description,objectif,resultat,date_creation,finish,illustration,blocage FROM "
        	    .Constants::TABLE_PROJET." WHERE id=?";
                                
        	$prepare = Functions::bindPrepare ( $bdd, $sql,$id);
        	$prepare->execute ();
           
        	$projet = null;
        	
        	while ($result = $prepare->fetch ()) {
        	  $projet = new Projet();
        	  $domaine = new Domaine();
        	  $client = new Client();
        	  $lieu = new Lieu();
        	  
        	  $domaine->setId($result["domaine_id"]);
        	  
        	  $client->setId($result["client_id"]);
        	  
        	  $lieu->setId($result["lieu_id"]);
        	    
        	 $projet->setId($result["id"]);
        	 $projet->setTitre($result["titre"]);
        	 $projet->setDateDebut(Functions::convertDateEnToFr($result["date_debut"]));
        	 $projet->setDateFin(Functions::convertDateEnToFr($result["date_fin"]));
        	 $projet->setDescription($result["description"]);
        	 $projet->setObjectif($result["objectif"]);
        	 $projet->setResultat($result["resultat"]);
        	 $projet->setDateCreation($result["date_creation"]);
        	 $projet->setClient($client);
        	 $projet->setLieu($lieu);
        	 $projet->setDomaine($domaine);
        	 $projet->setFinish($result["finish"]);
             $projet->setIllustration($result["illustration"]);
             $projet->setBlocage($result["blocage"]);
        	}

        	return $projet;
        } catch ( Exception $e ) {
        	die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
        	$prepare->closeCursor ();
         }
    }

    /**
     * MAJ de la description du projet
     * @param string|null $description
     * @param int $id
     */
    public function updateDescription(?string $description, int $id) : void{
        try {
                    
        	$bdd = Database::getInstance ();
        	$sql = "UPDATE ".Constants::TABLE_PROJET." SET description=? WHERE id=?";
                    
        	$prepare = Functions::bindPrepare ( $bdd, $sql, $description, $id);
        	$prepare->execute();
             
        } catch ( Exception $e ) {  
        	die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
        	$prepare->closeCursor ();
         }
    }

    /**
     * MAJ de l'objectif du projet
     * @param string|null $objectif
     * @param int $id
     */
    public function updateObjectif(?string $objectif, int $id) : void{
        try {
            
            $bdd = Database::getInstance ();
            $sql = "UPDATE ".Constants::TABLE_PROJET." SET objectif=? WHERE id=?";
            
            $prepare = Functions::bindPrepare ( $bdd, $sql, $objectif, $id);
            $prepare->execute();
            
        } catch ( Exception $e ) {
            die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
            $prepare->closeCursor ();
        }
    }

    /**
     * MAJ de l'objectif du projet
     * @param string|null $resultat
     * @param int $id
     */
    public function updateResultat(?string $resultat, int $id) : void{
        try {
            
            $bdd = Database::getInstance ();
            $sql = "UPDATE ".Constants::TABLE_PROJET." SET resultat=? WHERE id=?";
            
            $prepare = Functions::bindPrepare ( $bdd, $sql, $resultat, $id);
            $prepare->execute();
            
        } catch ( Exception $e ) {
            die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
            $prepare->closeCursor ();
        }
    }
    
    /**
     * Obtenir tous les projets en base de données
     * @return array
     */
    public function getAllProjet() : array{
        try {
                    
        	$bdd = Database::getInstance ();
        	$sql = "SELECT p.id,p.titre,p.date_debut,p.date_fin,p.finish,p.blocage,p.motif_blocage,p.date_blocage,d.nom AS domaine,l.nom AS lieu,c.nom AS client FROM "
        	    .Constants::TABLE_PROJET." AS p LEFT JOIN ".Constants::TABLE_DOMAINE." AS d ON p.domaine_id=d.id LEFT JOIN ".Constants::TABLE_LIEU.
        	   " AS l ON p.lieu_id=l.id LEFT JOIN ".Constants::TABLE_CLIENT." AS c ON p.client_id=c.id ";
                    
        	$prepare = Functions::bindPrepare ( $bdd, $sql);
        	$prepare->execute ();

        	$listeProjet = array();
            
        	while ($result = $prepare->fetch ()) {
        	    $projet = new Projet();
        	    $domaine = new Domaine();
        	    $lieu = new Lieu();
        	    $client = new Client();
        	    
        	    $domaine->setNom($result["domaine"]);
        	    
        	    $lieu->setNom($result["lieu"]);
        	    
        	    $client->setNom($result["client"]);
        	    
        	    $projet->setId($result["id"]);
        	    $projet->setTitre($result["titre"]);
        	    $projet->setDateDebut($result["date_debut"]);
        	    $projet->setDateFin($result["date_fin"]);
        	    $projet->setDateCreation($result["date_creation"]);
        	    $projet->setFinish($result['finish']);
                $projet->setBlocage($result["blocage"]);
        	    $projet->setClient($client);
        	    $projet->setLieu($lieu);
        	    $projet->setDomaine($domaine);
                $projet->setDateBlocage(Functions::convertDateEnToFr($result["date_blocage"]));
                $projet->setMotifBlocage($result["motif_blocage"]);
        	    
        	    $listeProjet[] = $projet;
        	    
        	}
        	
        	return $listeProjet;
             
        } catch ( Exception $e ) {  
        	die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
        	$prepare->closeCursor ();
         }
    }

    /** Ajouter ou update un projet qui contient une image d'illustration
     * @param Projet $projet
     * @param bool $withIllustration
     * @return void
     */
    public function addProjet(Projet $projet, bool $withIllustration) : void{
        try {
                    
        	$bdd = Database::getInstance ();
            if($withIllustration){
                $sql = "UPDATE ".Constants::TABLE_PROJET." SET titre=?, titre_url=?, date_debut=?, date_fin=?, domaine_id=?, lieu_id=?, client_id=?, description=?,".
                    "objectif=?, resultat=?, date_creation=?, finish=?, illustration=?,proccess=? WHERE id=?";

                $prepare = Functions::bindPrepare ( $bdd, $sql,
                    $projet->getTitre(),
                    $projet->getTitreUrl(),
                    $projet->getDateDebut(),
                    $projet->getDateFin(),
                    $projet->getDomaine()->getId(),
                    $projet->getLieu()->getId(),
                    $projet->getClient()->getId(),
                    $projet->getDescription(),
                    $projet->getObjectif(),
                    $projet->getResultat(),
                    $projet->getDateCreation(),
                    $projet->isFinish(),
                    $projet->getIllustration(),
                    $projet->isProccess(),
                    $projet->getId()
                );
            }else{
                $sql = "UPDATE ".Constants::TABLE_PROJET." SET titre=?, titre_url=?, date_debut=?, date_fin=?, domaine_id=?, lieu_id=?, client_id=?, description=?,".
                    "objectif=?, resultat=?, date_creation=?, finish=?, proccess=? WHERE id=?";

                $prepare = Functions::bindPrepare ( $bdd, $sql,
                    $projet->getTitre(),
                    $projet->getTitreUrl(),
                    $projet->getDateDebut(),
                    $projet->getDateFin(),
                    $projet->getDomaine()->getId(),
                    $projet->getLieu()->getId(),
                    $projet->getClient()->getId(),
                    $projet->getDescription(),
                    $projet->getObjectif(),
                    $projet->getResultat(),
                    $projet->getDateCreation(),
                    $projet->isFinish(),
                    $projet->isProccess(),
                    $projet->getId()
                );
            }

        	$prepare->execute ();
             
        } catch ( Exception $e ) {  
        	die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
        	$prepare->closeCursor ();
         }
    }

    /**Bloquer et debloquer un projet
     * @param Projet $projet
     * @return bool
     */
    public function bloquerAndDebloquerProjet(Projet $projet) : bool{
        try {

            $bdd = Database::getInstance ();
            $sql = "UPDATE ".Constants::TABLE_PROJET." SET blocage=?, motif_blocage=?, date_blocage=? WHERE id=?";
            $prepare = Functions::bindPrepare ($bdd, $sql,$projet->isBlocage(), $projet->getMotifBlocage(), $projet->getDateBlocage(), $projet->getId());

            return $prepare->execute();

        } catch ( Exception $e ) {
            die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
            $prepare->closeCursor ();
        }
    }

    public function getThreeLastProjet(bool $isFinish) : array{
        try {

            $bdd = Database::getInstance ();

            if($isFinish){
                $sql = "SELECT p.titre,p.titre_url,p.illustration,p.finish,p.date_debut,p.date_fin,l.nom AS lieuNom FROM ".Constants::TABLE_PROJET." AS p INNER JOIN ".Constants::TABLE_LIEU
                    ." AS l ON p.lieu_id=l.id WHERE finish=true AND proccess=false ORDER BY date_creation LIMIT 0,3";
            }else{
                $sql = "SELECT p.titre,p.titre_url,p.illustration,p.finish,p.date_debut,p.date_fin,l.nom AS lieuNom FROM ".Constants::TABLE_PROJET." AS p INNER JOIN ".Constants::TABLE_LIEU
                    ." AS l ON p.lieu_id=l.id WHERE finish=false AND proccess=false ORDER BY date_creation LIMIT 0,3";
            }

            $prepare = Functions::bindPrepare ($bdd, $sql);
            $prepare->execute();

            $listeProjet = array();

            while($result = $prepare->fetch()){

                $projet = new Projet();
                $lieu = new Lieu();

                $lieu->setNom($result["lieuNom"]);

                $projet->setTitre($result["titre"]);
                $projet->setTitreUrl($result["titre_url"]);
                $projet->setIllustration($result["illustration"]);
                $projet->setFinish($result["finish"]);
                $projet->setDateDebut(Functions::convertDateEnToFr($result["date_debut"]));
                $projet->setDateFin(Functions::convertDateEnToFr($result["date_fin"]));
                $projet->setLieu($lieu);

                $listeProjet[] = $projet;

            }

            return $listeProjet;

        } catch ( Exception $e ) {
            die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
            $prepare->closeCursor ();
        }
    }

    /** Obtenir un projet en BDD en se basant sur le titre_url
     * @param string|null $titreUrl
     * @return Projet|null
     */
    public function getOneProjetWithTitreUrl(?string $titreUrl) : ?Projet{
        try {

            $bdd = Database::getInstance ();
            $sql = "SELECT p.id,p.titre,p.date_debut,p.date_debut,p.date_fin,p.description,p.objectif,p.resultat,p.finish,p.illustration,p.blocage,p.proccess,c.nom AS clientNom,l.nom AS lieuNom,d.nom AS domaineNom FROM "
                .Constants::TABLE_PROJET." AS p INNER JOIN ".Constants::TABLE_CLIENT." AS c ON p.client_id=c.id INNER JOIN ".Constants::TABLE_LIEU." AS l ON p.lieu_id=l.id INNER JOIN ".Constants::TABLE_DOMAINE
                ." AS d ON p.domaine_id=d.id WHERE titre_url=?";

            $prepare = Functions::bindPrepare ($bdd, $sql,$titreUrl);
            $prepare->execute ();

            $projet = null;

            while ($result = $prepare->fetch ()) {
                $projet = new Projet();
                $domaine = new Domaine();
                $client = new Client();
                $lieu = new Lieu();

                $domaine->setNom($result["domaineNom"]);

                $client->setNom($result["clientNom"]);

                $lieu->setNom($result["lieuNom"]);

                $projet->setId($result["id"]);
                $projet->setTitre($result["titre"]);
                $projet->setDateDebut(Functions::convertDateEnToFr($result["date_debut"]));
                $projet->setDateFin(Functions::convertDateEnToFr($result["date_fin"]));
                $projet->setDescription($result["description"]);
                $projet->setObjectif($result["objectif"]);
                $projet->setResultat($result["resultat"]);
                $projet->setClient($client);
                $projet->setLieu($lieu);
                $projet->setDomaine($domaine);
                $projet->setFinish($result["finish"]);
                $projet->setIllustration($result["illustration"]);
                $projet->setBlocage($result["blocage"]);
                $projet->setProccess($result["proccess"]);
            }

            return $projet;
        } catch ( Exception $e ) {
            die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
            $prepare->closeCursor ();
        }
    }

    public function getAllProjetNotLocked() : array{
        try {

            $bdd = Database::getInstance ();
            $sql = "SELECT p.titre,p.titre_url,p.illustration,p.finish,p.date_debut,d.nom FROM ".Constants::TABLE_PROJET." AS p INNER JOIN ".Constants::TABLE_DOMAINE
            ." AS d ON p.domaine_id=d.id WHERE p.blocage=false AND p.proccess=false ORDER BY p.date_creation";

            $prepare = Functions::bindPrepare ($bdd, $sql);
            $prepare->execute();

            $listeProjet = array();

            while($result = $prepare->fetch()){
                $projet = new Projet();
                $domaine = new Domaine();

                $domaine->setNom($result["nom"]);

                $projet->setTitre($result["titre"]);
                $projet->setTitreUrl($result["titre_url"]);
                $projet->setIllustration($result["illustration"]);
                $projet->setDateDebut(Functions::convertDateEnToFr($result["date_debut"]));
                $projet->setFinish($result["finish"]);
                $projet->setDomaine($domaine);

                $listeProjet[] = $projet;
            }
            return $listeProjet;
        } catch ( Exception $e ) {
            die ( "Une erreur est survenue -> " . $e->getMessage () );
        } finally {
            $prepare->closeCursor ();
        }
    }

}

