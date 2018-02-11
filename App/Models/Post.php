<?php

namespace App\Models;

use PDO;

/**
 * Post Model
 * 
 * PHP Version 5.5
 */
class Post extends \Core\Model
{
    /**
     * Get all the posts as an associative array
     * 
     * @return array
     */
    public static function getAll() {
        $db = static::getDB();
        $stmt = $db->query('SELECT id, title, content FROM posts ORDER BY created_at');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
        
    }
}