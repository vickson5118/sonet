<?php
namespace manager;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/utils/Constants.php");

use Exception;
use PDO;
use utils\Constants;

class Database {
    private static $_instance;

    public static function getInstance() {
            if ( is_null(self::$_instance) ) {
                
                try {
                    
                    if($_SERVER['SERVER_NAME'] == "sonet.local"){
                        
                        self::$_instance = new PDO("mysql:host=" . Constants::MYSQL_HOST . ";dbname=" . Constants::DBNAME 
                            . ";charset=utf8", Constants::USERNAME, Constants::PASSWORD, array(
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                        ));
                        
                    }else{
                        self::$_instance = new PDO("mysql:host=" . Constants::MYSQL_HOST . ";dbname=" . Constants::ONLINE_DBNAME
                            . ";charset=utf8", Constants::ONLINE_USERNAME, Constants::ONLINE_PASSWORD, array(
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                        ));
                    }
                    
                } catch ( Exception $e ) {
                    die("Erreur " . $e->getMessage());
                }
            }
        
        
        return self::$_instance;
    }
}

