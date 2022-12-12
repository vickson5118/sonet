<?php

namespace utils;

require_once($_SERVER["DOCUMENT_ROOT"]."/utils/Constants.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/phpmailer/Exception.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/phpmailer/PHPMailer.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/phpmailer/SMTP.php");

use IntlDateFormatter;
use PHPMailer\PHPMailer\PHPMailer;
use DateTime;
use Exception;
use PDO;
use PDOStatement;
use manager\UtilisateurManager;
use manager\ProjetManager;
use manager\ClientManager;
use manager\LieuManager;
use manager\DomaineManager;
use PHPMailer\PHPMailer\SMTP;

class Functions{
    
    private function __construct(){}

    /**
     * Recuperer le champ en supprimant les caractères html ainsi que les espaces de debut et fin
     * @param string|null $value
     * @return NULL|string
     */
    public static function getValueChamp(?string $value) : ?string{
        if($value == null){
            return null;
        }
        return strip_tags(trim($value));
    }

    /**
     * Verifie une chaine de caractères
     * @param string|null $texte
     * @param string $nomChamp
     * @param int $minLength
     * @param int $maxLength
     * @param bool $required
     * @throws Exception
     */
    public static function validTexte (?string $texte, string $nomChamp,int $minLength, int $maxLength, bool $required){
        if (($texte == NULL || empty(trim($texte))) && $required) {
            throw new Exception("Le champ " . $nomChamp . " ne peut être vide.");
        } elseif (trim($texte) != null && iconv_strlen(trim($texte)) < $minLength ) {
            throw new Exception("Le champ " . $nomChamp . " ne peut être inférieur à " .$minLength . " caractères.");
        } elseif (trim($texte) != null && iconv_strlen(trim($texte)) > $maxLength) {
            throw new Exception("Le champ " . $nomChamp . " ne peut excéder " .$maxLength . " caractères.");
        }
    }
    
    /**
     * Genere une requete
     *
     * @param PDO $bdd
     * @param string $sql
     * @param array $args
     * @return PDOStatement
     */
    public static function bindPrepare (PDO $bdd, string $sql, ...$args): PDOStatement{
        $prepare = $bdd->prepare($sql);
        for ($i = 0; $i < sizeof($args); $i ++) {
            if(is_bool($args[$i]))
                $prepare->bindParam($i + 1, $args[$i], PDO::PARAM_BOOL);
            else
                $prepare->bindParam($i + 1, $args[$i]);
        }
        return $prepare;
    }
    
    /**
     * Generer une chaine de caractères aleatoire
     *
     * @param int $length
     *            la longeur de la chaine
     * @return string
     */
    public static function generatePassword (int $length) : string{
        $allChars = "!:crfWSvt?.(-~#{[167./-+$%;,!_&|\@]}=^aqw23zkolsAQWxedgbTGVCFR45EDXZyhnuU89JNBHYjipmMPLOKI";
        
        $password = "";
        for ($i = 0; $i < $length; $i ++) {
            $allChars = str_shuffle($allChars);
            $password = $allChars[$i] . $password;
        }
        
        return $password;
    }

    /**
     * Verification de la validation email
     * @param string|null $email
     * @param UtilisateurManager $utilisateurManager
     * @throws Exception
     */
    public static function validEmail (?string $email,UtilisateurManager $utilisateurManager){
        if ($email == null || iconv_strlen($email) == 0) {
            throw new Exception("Le champ adresse E-mail ne peut être vide.");
        } elseif (iconv_strlen($email) < 10) {
            throw new Exception("Le format de l'adresse E-mail est incorrect.");
        } elseif (iconv_strlen($email) > 255) {
            throw new Exception("Le champ adresse E-mail ne peut excéder 250 caractères.");
        } elseif (! preg_match("#^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\\.[a-z]{2,4}$#",$email)) {
            throw new Exception("Le format de l'adresse E-mail est incorrect.");
        } elseif ($utilisateurManager->emailExist($email)) {
            throw new Exception("L'adresse E-mail existe déja.Veuillez choisir une autre adresse.");
        }
    }

    /** Valide un email de la partie contactez-nous
     * @param string|null $email
     * @return void
     * @throws Exception
     */
    public static function validContactEmail (?string $email){
        if ($email == null || iconv_strlen(ltrim($email)) == 0) {
            throw new Exception("Le champ adresse mail ne peut être vide.");
        } elseif (iconv_strlen($email) < 10) {
            throw new Exception( "Le champ adresse mail ne peut être inférieur à 10 caractères.");
        } elseif (iconv_strlen($email) > 255) {
            throw new Exception( "Le champ adresse mail ne peut excéder 250 caractères.");
        } elseif (! preg_match("#^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\\.[a-z]{2,4}$#",$email)) {
            throw new Exception( "Le format de l'adresse mail est incorrect.");
        }
    }

    /** Valider le format du téléphone
     * @param string|null $telephone
     * @return void
     * @throws Exception
     */
    public static function validTelephone(?string $telephone){
        if($telephone == null){
            throw new Exception("Le champ téléphone ne peut être vide.");
        }else if(iconv_strlen($telephone) > 0 && !preg_match("#^[0-9]{2}([. -]?[0-9]{2}){4}$#",$telephone)){
            throw new Exception("Le format du téléphone est incorrect. Le format autorisé est +225 07 79 79 05 03");
        }
    }

    /**
     * Envoyer un mail
     * @param string $toEmail
     * @param string $objet
     * @param string $message
     * @param string|null $altMessage
     * @return bool
     * @throws Exception
     */


    public static function sendMail(string $toEmail,string $objet,string $message,?string $altMessage): bool{

        $mailer = new PHPMailer(true);

        try{

            // Debutg
             $mailer -> SMTPDebug = SMTP::DEBUG_SERVER;

            // config SMTP
            $mailer -> isSMTP();
            $mailer -> Host = Constants::SMTP_HOST;
            $mailer -> Port = Constants::SMTP_PORT;
            $mailer -> SMTPAuth = true;
            $mailer -> Username = Constants::SMTP_USERNAME;
            $mailer -> Password = Constants::SMTP_PASSWORD;
            $mailer -> SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

            // Charset
            $mailer -> CharSet = "utf-8";

            // Destinataire et expediteur
            $mailer -> setFrom(Constants::SMTP_USERNAME, "L'équipe ".Constants::ENTREPRISE_NAME);
            $mailer -> addAddress($toEmail);

            // Message
            $mailer -> isHTML();
            $mailer -> Subject = $objet;
            $mailer -> Body = $message;

            $mailer -> AltBody = $altMessage;

            return $mailer->send();

        } catch(\PHPMailer\PHPMailer\Exception $e){
            throw new Exception("Une erreur est survenue lors de l'envoi du mail. Vérifier votre connexion internet et réessayer ultérieurement10.");
        }
    }

    /**
     * Convertir de format de la date Anglaise en format Francais
     * @param string|null $date
     * @return string|NULL
     */
    public static function convertDateEnToFr(?string $date): ?string {
        return ($date == null) ? null :
        (DateTime::createFromFormat("Y-m-d", $date))->format("d/m/Y");
    }

    /**
     * Validation du titre du projet
     * @param ProjetManager $projetManager
     * @param string|null $titre
     * @param string $nomChamp
     * @param int $minLength
     * @param int $maxLength
     * @throws Exception
     */
    public static function validTitreProjet(ProjetManager $projetManager, ?string $titre, string $nomChamp,int $minLength, int $maxLength){
        if($projetManager->projetExist($titre)){
            throw new Exception("Le titre du projet existe déjà. Merci de choisir un autre titre.");
        }else {
            self::validTexte($titre, $nomChamp, $minLength, $maxLength, true);
        }
    }

    /**Verfier que le titre du projet existe déja en BDD
     * @param ProjetManager $projetManager
     * @param string|null $titre
     * @param int $id
     * @param string $nomChamp
     * @param int $minLength
     * @param int $maxLength
     * @return void
     * @throws Exception
     */
    public static function validTitreProjetExist(ProjetManager $projetManager, ?string $titre, int $id, string $nomChamp,int $minLength, int $maxLength){
        if($projetManager->projetTitreExist($titre, $id)){
            throw new Exception("Le titre du projet existe déjà. Merci de choisir un autre titre.");
        }else {
            self::validTexte($titre, $nomChamp, $minLength, $maxLength, true);
        }
    }

    /**
     * Verifie que le client n'existe pas deja en BDD
     * @param ClientManager $clientManager
     * @param string|null $nom
     * @param string $nomChamp
     * @param int $minLength
     * @param int $maxLength
     * @throws Exception
     */
    public static function validClientNon(ClientManager $clientManager, ?string $nom, string $nomChamp,int $minLength, int $maxLength){
        if($clientManager->clientExist($nom)){
            throw new Exception("Le nom du client existe déjà. Merci de choisir un autre nom.");
        }else {
            self::validTexte($nom, $nomChamp, $minLength, $maxLength, true);
        }
    }

    /**
     * Verifie que le lieu n'existe pas deja
     * @param LieuManager $lieuManager
     * @param string|null $nom
     * @param string $nomChamp
     * @param int $minLength
     * @param int $maxLength
     * @throws Exception
     */
    public static function validLieuNon(LieuManager $lieuManager, ?string $nom, string $nomChamp,int $minLength, int $maxLength){
        if($lieuManager->lieuExist($nom)){
            throw new Exception("Le nom du lieu existe déjà. Merci de choisir un autre nom.");
        }else {
            self::validTexte($nom, $nomChamp, $minLength, $maxLength, true);
        }
    }

    /**
     * Verifie si le domaine existe
     * @param DomaineManager $domaineManager
     * @param string|null $nom
     * @param string $nomChamp
     * @param int $minLength
     * @param int $maxLength
     * @throws Exception
     */
    public static function validDomaineNon(DomaineManager $domaineManager, ?string $nom, string $nomChamp,int $minLength, int $maxLength){
        if($domaineManager->domaineExist($nom)){
            throw new Exception("Le nom du lieu existe déjà. Merci de choisir un autre nom.");
        }else {
            self::validTexte($nom, $nomChamp, $minLength, $maxLength, true);
        }
    }

    /**
     * Convertir le format de la date Francais en format Anglaise
     * @param string|null $date
     * @return string|NULL
     */
    public static function convertDateFrToEn(?string $date): ?string {
        return ($date == null) ? null :
        (DateTime::createFromFormat("d/m/Y", $date))->format("Y-m-d");
    }

    /**
     * @param $image
     * @param int $imageSize
     * @param string $imageSizeInMo
     * @param int $imageUploadWidth
     * @param int $imageUploadHeight
     * @return string|null
     * @throws Exception
     */
    public static function validImage($image, int $imageSize, string $imageSizeInMo,int  $imageUploadWidth, int $imageUploadHeight): ?string{

        if(empty($image["name"]) && !isset($image)){
            throw new Exception("Le champ de l'image ne peut être vide.");
        }else{

            if($image["error"] != 0){
                throw new Exception("Une erreur est survenue, veuillez reessayer ultérieurement.");
            }

            $imageInfo = getimagesize($image["tmp_name"]);
            $imageWidth = $imageInfo[0];
            $imageHeight = $imageInfo[1];
            $imageTypeMime = $imageInfo["mime"];

            if($image["size"] > $imageSize){
                throw new Exception("La taille de l'image ne doit pas excéder ".$imageSizeInMo." Mo");
            }

            $extension = strtolower(pathinfo($image["name"],PATHINFO_EXTENSION));
            $allowExtension = array("jpg","png","jpeg");
            $allowTypeMime = array("image/jpg","image/jpeg","image/png");

            if(!in_array($extension, $allowExtension) || !in_array($imageTypeMime, $allowTypeMime)){
                throw new Exception("Le format de l'image n'est pas correct. Les formats autorisés sont: png, jpeg, jpg");
            }

            if($imageWidth < $imageUploadWidth || $imageHeight < $imageUploadHeight){
                throw new Exception("La dimension de l'image autorisée est: ".$imageUploadWidth."*".$imageUploadHeight);
            }

            return $extension;
        }

    }

    /**
     * Validation de la date de naissance au format francais
     * @param string|null $date
     * @param bool $isNull
     * @throws Exception
     */
    public static function validDate(?string $date, bool $isNull) : void{
        if($date == null && iconv_strlen($date) == 0 && !$isNull){
            throw new Exception("Le format de la date est incorrect.");
        }else if(!preg_match("#^[0-9]{2}/[0-9]{2}/[0-9]{4}$#",$date)){
            throw new Exception("Le format de la date est incorrect.");
        }
    }

    /** créer un format de lien
     * @param string|null $texte
     * @return string|null
     */
    public static function formatUrl(?string $texte): ?string{
        $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');

        $texteSansAccent = str_replace($search, $replace, $texte);
        $url = str_replace(" ", "-", $texteSansAccent);
        return preg_replace("#-{2,}#", "-", $url);
    }

    /**
     * Mettre la date au format fr avec le mois abrégé
     * @param string|null $date
     * @return string|NULL
     * @throws Exception
     */
    public static function convertDateFrToFrMonthAbrege(?string $date): ?string {
        $dateFormatter = new IntlDateFormatter(
            'fr_FR',
            IntlDateFormatter::MEDIUM,
            IntlDateFormatter::NONE,
            'Africa/Abidjan',
            IntlDateFormatter::GREGORIAN
        );
        return $date == null ? null : $dateFormatter->format(new DateTime(DateTime::createFromFormat("d/m/Y", $date)->format("Y-m-d")));
    }

    /**
     * @param string|null $date
     * @return string|null
     * @throws Exception
     */
    public static function convertDateFrToFrMonthLong(?string $date): ?string {
        $dateFormatter = new IntlDateFormatter(
            'fr_FR',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            'Africa/Abidjan',
            IntlDateFormatter::GREGORIAN
        );
        return $date == null ? null : $dateFormatter->format(new DateTime(DateTime::createFromFormat("d/m/Y", $date)->format("Y-m-d")));
    }

    /** Formatter la date du projet
     * @param string|null $dateDebut
     * @param string|null $dateFin
     * @return string|null
     * @throws Exception
     */
    public static function formatProjetDate(?string $dateDebut, ?string $dateFin): ?string{

        if($dateDebut == null || $dateFin == null){
            return null;
        }

        $dateDebut = DateTime::createFromFormat("d/m/Y", $dateDebut)->format("d/n/Y");
        $dateFin = DateTime::createFromFormat("d/m/Y", $dateFin)->format("d/n/Y");

        $monthTab = [ "Jan", "Fév", "Mar", "Avr", "Mai", "Juin","Juil", "Août", "Sept", "Oct", "Nov", "Déc" ];
        $dateDebutTab = explode("/", $dateDebut);
        $dateFinTab = explode("/", $dateFin);

        if($dateDebutTab[1] == $dateFinTab[1] && $dateDebutTab[2] == $dateFinTab[2]){
            return $dateDebutTab[0]." - ".$dateFinTab[0]." ".$monthTab[(intval($dateDebutTab[1])-1)]." ".$dateDebutTab[2];
        }else if($dateDebutTab[1] == $dateFinTab[1] && $dateDebutTab[2] != $dateFinTab[2]){
            return self::convertDateFrToFrMonthAbrege($dateDebut)." - ".self::convertDateFrToFrMonthAbrege($dateFin);
        }else if($dateDebutTab[1] != $dateFinTab[1] && $dateDebutTab[2] == $dateFinTab[2]){
            return $dateDebutTab[0]." ".$monthTab[(intval($dateDebutTab[1])-1)]." - ".$dateFinTab[0]." ".$monthTab[(intval($dateFinTab[1])-1)]." ".$dateDebutTab[2];
        }else{
            return self::convertDateFrToFrMonthAbrege($dateDebut)." - ".self::convertDateFrToFrMonthAbrege($dateFin);
        }

    }


}

