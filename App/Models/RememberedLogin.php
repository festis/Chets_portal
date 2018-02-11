<?php

namespace App\Models;
use App\Token;
use PDO;
/**
 * Remembered Login Model
 * 
 * PHP version 5.5
 */
class RememberedLogin extends \Core\Model
{
    /**
     * Find a remembered login model by the token
     * 
     * @param string $token the remembered login token
     * 
     * @return mixed Remembered login object if found, False otherwise
     */
    public static function findByToken($token) {
        $token = new Token($token);
        $token_hash = $token->getHash();
        
        $sql = 'SELECT * FROM remembered_logins
                WHERE token_hash = :token_hash';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);
        
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Get the user object associated with this remembered login
     * 
     * @return User the user object
     */
    public function getUser() {
        return User::findById($this->user_id);
    }
    
    /**
     * See if the remember token has expired or not, based on the current system time
     * 
     * @return boolean True if the token has expired, false otherwise
     */
    public function hasExpired() {
        return strtotime($this->expires_at) < time();
    }
    
    /**
     * Delete the remembered login record in the database when the user logs out
     * 
     * @return void
     */
    public function delete() {
        $sql = 'DELETE FROM remembered_logins'
                . ' WHERE token_hash = :token_hash';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':token_hash', $this->token_hash, PDO::PARAM_STR);
        
        $stmt->execute();
    }
}