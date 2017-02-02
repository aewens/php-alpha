<?php

require_once "config.php";

class DB
{
    private static $instance = null;
    
    public static function connect() {
        if (self::$instance == null) {
            self::$instance = new PDO(DB_DSN, DB_USER, DB_PASS, 
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        }
        
        return self::$instance;
    }
    
    public static function query($query, $params = array()) {
        $statement = self::connect()->prepare($query);
        $statement->execute($params);
        
        if (explode(" ", $query)[0] == "SELECT") {
            $data = $statement->fetchAll();
            
            return $data;
        }
    }
}
