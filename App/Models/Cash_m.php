<?php

namespace App\Models;

use PDO;
use DateTime;
use App\Models\User;
use App\Models\Helpers;

/**
 * Runboard Model
 * 
 * PHP Version 5.5
 */
class Cash_m extends \Core\Model
{
    public static function getMoney($table, $store) {
        $db = static::getDB();
        
        // figure out the last record in the table
        $stmt = $db->query(
                "SELECT id FROM $table "
                . "WHERE store_id = $store "
                . "ORDER BY id DESC LIMIT 1"
                );
        $id = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $record = $id[0]['id'];
        
        // Then pull it
        $stmt = $db->query(
                "SELECT * FROM $table "
                . "WHERE id = $record"
                );
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    public static function save($data) {

        // Save the Bills
        $sql = "INSERT INTO bills ("
                . "store_id, "
                . "hundreds, "
                . "fifties, "
                . "twenties, "
                . "tens, "
                . "fives, "
                . "ones) "
                . "VALUES ("
                . ":store_id, "
                . ":hundreds, "
                . ":fifties, "
                . ":twenties, "
                . ":tens, "
                . ":fives, "
                . ":ones)";
        $db = static::getDB();
           
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':store_id', isset($data['store_id'])? $data['store_id']: '0', PDO::PARAM_INT);
        $stmt->bindValue(':hundreds', isset($data['hundreds'])? $data['hundreds']: '0', PDO::PARAM_INT);
        $stmt->bindValue(':fifties', isset($data['fifties'])? $data['fifties']: '0', PDO::PARAM_INT);
        $stmt->bindValue(':twenties', isset($data['twenties'])? $data['twenties']: '0', PDO::PARAM_INT);
        $stmt->bindValue(':tens', isset($data['tens'])? $data['tens']: '0', PDO::PARAM_INT);
        $stmt->bindValue(':fives', isset($data['fives'])? $data['fives']: '0', PDO::PARAM_INT);
        $stmt->bindValue(':ones', isset($data['ones'])? $data['ones']: '0', PDO::PARAM_INT);
        
        $stmt->execute();
        
        // Save the coins
        $sql = "INSERT INTO coins ("
                . "store_id, "
                . "quarters, "
                . "dimes, "
                . "nickles, "
                . "pennies) "
                . "VALUES ("
                . ":store_id, "
                . ":quarters, "
                . ":dimes, "
                . ":nickles, "
                . ":pennies)";
           
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':store_id', isset($data['store_id'])? $data['store_id']: '0', PDO::PARAM_INT);
        $stmt->bindValue(':quarters', isset($data['quarters'])? $data['quarters']: '0', PDO::PARAM_INT);
        $stmt->bindValue(':dimes', isset($data['dimes'])? $data['dimes']: '0', PDO::PARAM_INT);
        $stmt->bindValue(':nickles', isset($data['nickles'])? $data['nickles']: '0', PDO::PARAM_INT);
        $stmt->bindValue(':pennies', isset($data['pennies'])? $data['pennies']: '0', PDO::PARAM_INT);
        
        $stmt->execute();
        
        // Save the propane
        $sql = "INSERT INTO propane ("
                . "store_id, "
                . "propane, "
                . "percent) "
                . "VALUES ("
                . ":store_id, "
                . ":propane, "
                . ":percent)";
           
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':store_id', isset($data['store_id'])? $data['store_id']: '0', PDO::PARAM_INT);
        $stmt->bindValue(':propane', isset($data['propane'])? $data['propane']: '0', PDO::PARAM_INT);
        $stmt->bindValue(':percent', isset($data['propane_percent'])? $data['propane_percent']: '0', PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}