<?php

namespace Core;

use PDO;
use App\Config;

/**
 * Base model
 * 
 * PHP version 5.5
 */
abstract class Model
{
    /**
     * Get the database connection
     * 
     * @return mixed
     */
    protected static function getDB()
    {
        static $db = NULL;
        
        if ($db === NULL) {
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . 
                Config::DB_NAME . ';charset=utf8';  
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);
            
            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }
    
    /**
     * Get a run based on the transID
     * 
     * @return array
     */
    protected static function getById($columnName, $transID, $table) {
        $db = static::getDB();
        $stmt = $db->query(
                "SELECT * FROM $table "
                . "WHERE $columnName='$transID'"
                );
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }
}