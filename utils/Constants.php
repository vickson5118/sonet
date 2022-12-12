<?php

namespace utils;

class Constants{
    
    private function __construct(){}
    
    /**
     * BDD CONFIG
     */
    public const MYSQL_HOST = "localhost";
    public const DBNAME = "sonet";

    public const USERNAME = "root_sonet";
    public const PASSWORD = "mR@!)PQIYOQuZI[W";
    /**
     * ONLINE BDD CONFIG
     */
    public const ONLINE_DBNAME = "id19728815_sonet";
    public const ONLINE_USERNAME = "id19728815_root_sonet";
    public const ONLINE_PASSWORD = "tp}6!1L%^0G4/JDo";
    
    public const MYSQL_HOST_ONLINE = "185.98.131.176";
    public const DBNAME_ONLINE = "gehan1793907";
    public const USERNAME_ONLINE = "gehan1793907";
    public const PASSWORD_ONLINE = "8lwd3lrpba";
    
    /**
     * TABLES
     */
    public const TABLE_UTILISATEUR = "utilisateurs";
    public const TABLE_CLIENT = "clients";
    public const TABLE_DOMAINE = "domaines";
    public const TABLE_LIEU = "lieux";
    public const TABLE_PROJET = "projets";
    public const TABLE_FILE = "files";
    public const TABLE_PARTENAIRE = "partenaires";
    public const TABLE_CONTACT = "contacts";
    
    /**
     * PASSWORD
     */
    public const PASSWORD_ADMIN_LENGTH = 16;
    
    /**
     * TYPE COMPTE
     */
    public const COMPTE_ADMIN = 1;
    
    /**
     * SMTP IDENTIFICATION
     */
    public const SMTP_USERNAME = "info@gehant-acedemie.net";
    public const SMTP_PASSWORD = "hV1!7AEfD!bzvXz";
    public const SMTP_PORT = 465;
    public const SMTP_HOST = "mail53.lwspanel.com";
    
    /* FOLDERS*/
    public const PROJET_FILES_FOLDER = "/uploads/projets/";
    public const PROJET_ILLUSTATION_FOLDER = "/uploads/projets/illustration/";
    public const PARTENAIRE_FOLDER = "/uploads/partenaires/";
    
    /* AUTRES CONSTANTES */
    public const ENTREPRISE_NAME = "SONET-CI";
    public const PASSWORD_GENERATE_START_SALT = "TGkik74GSF@856";
    public const PASSWORD_GENERATE_END_SALT = "ohsg85/7_n&5shjHYF";
    public const TAILLE_ILLUSTRATION = 10000000;
    
}

