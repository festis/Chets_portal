<?php

namespace App\Models;

use PDO;
use App\Models\User;

/**
 * Runboard Model
 * 
 * PHP Version 5.5
 */
class Helpers extends \Core\Model
{
    /**
     * Get a list of all the stores
     * 
     * @return array
     */
    public static function getStores() {
        $db = static::getDB();
        $stmt = $db->query(
                "SELECT * FROM stores "
                . "ORDER BY storeNumber ASC"
                );
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        return $results;
    }
    
    /**
     * Parse the id from a URL
     * 
     * $return string
     */
    public static function parseId() {
        // Need to parse the URL to find the trans ID we are going to edit
            $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $uri_segments = explode('/', $uri_path);

            // finding the trans id from the URI.
            $num_segments = count($uri_segments) - 2;        
            $transID = $uri_segments[$num_segments];
            
            return $transID;
    }
}