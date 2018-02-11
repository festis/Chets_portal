<?php

namespace App\Models;

use PDO;
use App\Models\User;
use App\Models\Helpers;

/**
 * Runboard Model
 * 
 * PHP Version 5.5
 */
class Runboard_m extends \Core\Model
{
    public function __construct($data) {        
        // Convert the $data array into object properties
        // e.g. $data['name' => 'Bill']; changes to $user->name = 'Bill'
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        // Need to clean up the store numbers
        $this->fromStore = preg_replace("/[^0-9]/", '', $this->fromStore);
        $this->toStore = preg_replace("/[^0-9]/", '', $this->toStore);
        
    }


    /**
     * Delete a record from the db
     * 
     * @return void
     */
    public static function delete($id) {
        $sql = 'DELETE FROM runboard WHERE transID = :id LIMIT 1';
        
        $db = static::getDB();        
        $stmt = $db->prepare($sql);        
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }


    /**
     * Get the runs associated with a store id and by movement type
     * 
     * @return array
     */
    public static function getByStoreIdMove($storeID, $orderedBy) {
        $db = static::getDB();
        $stmt = $db->query(
                "SELECT transID, fromStore, toStore, category, item, description, dateNeeded, movementType, timeNeeded, itemStatus, notes "
                . "FROM runboard WHERE storeID=$storeID AND movementType='$orderedBy'"
                );
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }
    
    /**
     * Get all the runs based on just movement type
     * 
     * @return array
     */
    public static function getAllByMove($orderedBy) {
        $db = static::getDB();
        $stmt = $db->query(
            "SELECT * FROM runboard WHERE movementType='$orderedBy'"
            );
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }
    
    /**
     * Get a list of all the run types
     * 
     * @return array
     */
    public static function getTypes() {
        $db = static::getDB();
        $stmt = $db->query(
                "SELECT * FROM runtype"
                );
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }
    
    /**
     * Get a list of all the run status types
     * 
     * @return array
     */
    public static function getStatus() {
        $db = static::getDB();
        $stmt = $db->query(
                "SELECT * FROM itemstatus"
                );
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }
    
    /**
     * Get a run based on the transID
     * 
     * @return array
     */
    public static function getById($transID, $columnName = 'transID', $table = 'runboard') {
        $results = parent::getById($columnName, $transID, $table);        
        return $results;
        
        return $results;
    }
    
    /**
     * Get a run based on the status
     * 
     * @return array
     */    
    public static function getByStatus($status) {
        $db = static::getDB();
        $stmt = $db->query(
                "SELECT * FROM runboard "
                . "WHERE itemStatus='$status'"
                );
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }
    
    /**
     * Get all runs to or from a store that was not entered by you
     * 
     * @return array
     */    
    public static function getByStoreNotOwn($store) {
        $db = static::getDB();
        $stmt = $db->query(
                "SELECT * FROM runboard "
                . "WHERE (fromStore='$store' AND storeID <>'$store')"
                . "OR (toStore='$store' AND storeID <>'$store')"
                
                );
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }
    
    /**
     * Save the run with the current property values
     * 
     * @return boolean TRUE if the user was saved, FALSE otherwise
     */
    public function save($storeID = NULL, $update = '') {        
        // Validate the data sent from the controller
        $this->validate();
        if ($update == '') {
                $sql = "INSERT INTO runboard (
                            fromStore, 
                            toStore, 
                            category, 
                            item, 
                            description, 
                            dateNeeded, 
                            storeID, 
                            movementType,
                            timeNeeded, 
                            itemStatus, 
                            notes) 
                        VALUES (
                            :fromStore, 
                            :toStore, 
                            :category, 
                            :item, 
                            :description, 
                            :dateNeeded, 
                            :storeID, 
                            :runType, 
                            :timeNeeded, 
                            :itemStatus, 
                            :notes)";
        } else {
            $sql = "UPDATE runboard SET
                        fromStore=:fromStore,
                        toStore=:toStore,
                        category=:category,
                        item=:item, 
                        description=:description,
                        dateNeeded=:dateNeeded,
                        storeID=:storeID, 
                        movementType=:runType,
                        timeNeeded=:timeNeeded, 
                        itemStatus=:itemStatus,
                        notes=:notes "
                        . "WHERE transID=$this->transID";
        }
        
        if (empty($this->errors)) {
            
            $db = static::getDB();
           
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':fromStore',      $this->fromStore, PDO::PARAM_INT);
            $stmt->bindValue(':toStore',        $this->toStore, PDO::PARAM_INT);
            $stmt->bindValue(':category',       $this->category, PDO::PARAM_INT);
            $stmt->bindValue(':item',           $this->item, PDO::PARAM_INT);
            $stmt->bindValue(':description',    $this->description, PDO::PARAM_STR);
            $stmt->bindValue(':dateNeeded',     $this->dateNeeded, PDO::PARAM_STR);
            $stmt->bindValue(':storeID',        $storeID, PDO::PARAM_INT);
            $stmt->bindValue(':runType',        $this->runType, PDO::PARAM_STR);
            $stmt->bindValue(':timeNeeded',     $this->timeNeeded, PDO::PARAM_STR);
            $stmt->bindValue(':itemStatus',     $this->itemStatus, PDO::PARAM_STR);
            $stmt->bindValue(':notes',          $this->notes, PDO::PARAM_STR);

            return $stmt->execute();
        }
        
        return FALSE;
    }
    
    /**
     * Validate current property values, adding validation error messages to the errors array property
     * 
     * @return void
     */
    public function validate() {
        // Name - this is required
        if ($this->description == '') {
            $this->errors[] = 'Description is required';
        }        
        
        // Category number - must be a number
        if (!is_numeric($this->category)) {
            $this->category = 0;
        } 
        
        // Item number - must be a number
        if (!is_numeric($this->item)) {
            $this->item = 0;
        } 
    }
    
    /**
     * get all runs from a specific store, to a specific store
     * 
     * @return array
     */
    public static function getByMovement($fromStore, $toStore) {
        $db = static::getDB();
        $stmt = $db->query(
                "SELECT * FROM runboard "
                . "WHERE fromStore='$fromStore' AND toStore='$toStore' "
                . "ORDER BY case movementType WHEN 'Rental Run' THEN 1 "
                . "WHEN 'Inter-Company' THEN 2 WHEN 'Parts' THEN 3 WHEN 'Other' THEN 4 ELSE 5 END"
                );
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }
    
    /**
     * This function checks to see if a run already exists before inserting into the db
     * 
     * @return array 
     */
    public function runExists() {
        $db = static::getDB();
        $stmt = $db->query(
                "SELECT * FROM runboard "
                . "WHERE fromStore='$this->fromStore' "
                . "AND toStore='$this->toStore' "
                . "AND category='$this->category' "
                . "AND item='$this->item' "
                );
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }
}