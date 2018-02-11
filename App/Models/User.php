<?php

namespace App\Models;

use PDO;
use App\Token;
use App\Mail;

/**
 * User Model
 * 
 * PHP version 5.5
 */
class User extends \Core\Model
{
    /**
     * Error messages
     * 
     * @var array
     */
    public $errors = array();
    
    /**
     * Class constructor
     * 
     * @param array $data Initial property values
     * @return void
     */
    public function __construct($data = array()) {
        // Convert the $data array into object properties
        // e.g. $data['name' => 'Bill']; changes to $user->name = 'Bill'
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
    
    /**
     * Get all the users as an associative array
     * 
     * @return array
     */
    public static function getAll() {
        $db = static::getDB();
        $stmt = $db->query('SELECT id, name FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Save the user model with the current property values
     * 
     * @return boolean TRUE if the user was saved, FALSE otherwise
     */
    public function save() {
        $this->validate();
        
        if (empty($this->errors)) {            
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            
            $token = new Token();
            $hashed_token = $token->getHash();
            $this->activation_token = $token->getValue();
            
            $sql = 'INSERT INTO users (name, email, password_hash, storeNumber, activation_hash)
                    VALUES (:name, :email, :password_hash, :storeNumber, :activation_hash)';
            $db = static::getDB();
           
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':storeNumber', $this->storeNumber, PDO::PARAM_INT);
            $stmt->bindValue(':activation_hash', $hashed_token, PDO::PARAM_STR);

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
        if ($this->name == '') {
            $this->errors[] = 'Name is required';
        }
        
        // email address - must be valid
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === FALSE) {
            $this->errors[] = 'Invalid email';
        }
        
        // email must be a chets email
        if (strpos($this->email, 'chetsrentall.com') == FALSE) {
            $this->errors[] = 'You must use a Chet\'s rent all email address';
        }
        
        // emails must be unique
        if (static::emailExists($this->email, isset($this->id) ? $this->id : NULL)) {
            $this->errors[] = 'That email address is taken';
        } 
        
        // password validation
        if (isset($this->password)) {
            // password must be over 6 characters in length
            if (strlen($this->password) < 6) {
                $this->errors[] = 'Password must be at least 6 characters in length';
            }

            // password must contain at least one letter
            if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
                $this->errors[] = 'Password needs at least one letter';
            }

            // password must contain at lease one number
            if (preg_match('/.*\d+.*/i', $this->password) == 0) {
                $this->errors[] = 'Password needs at least one number';
            }
        }
        // Store number - must be a number
        if (!is_numeric($this->storeNumber)) {
            $this->errors[] = 'Your store number must be an integer';
        } 
    }
    
    /**
     * See if a user record already exists with the specified email
     * 
     * @param string $email email address to search for
     * @return boolean True if a record already exists, False otherwise
     */
    public static function emailExists($email, $ignore_id = null) {
        $user = static::findByEmail($email);
        
        if ($user) {
            if ($user->id != $ignore_id) {
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    /**
     * Find a user model by email address
     * 
     * @param string $email email address to search for
     * 
     * @return mixed User object if found, False otherwise
     */
    public static function findByEmail($email) {
        $sql = 'SELECT * FROM users WHERE email = :email';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        
        $stmt->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Authenticate a user by email and password
     * 
     * @param string $email email address
     * @param string $password password
     * 
     * @return mixed The user object or false if authentication fails
     */
    public static function authenticate($email, $password) {
        $user = static::findByEmail($email);
        
        if ($user && $user->is_active) {
            if(password_verify($password, $user->password_hash)) {
                return $user;
            }
        }
        return FALSE;
    }
    
    /**
     * Find a user object by ID
     * 
     * @param string @id the user ID
     * 
     * @return mixed User object if found, False otherwise
     */
    public static function findById($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Remember the login by inserting a new unique token into the remembered_logins table
     * for this user record
     * 
     * @return boolean True if the login was remembered successfully, false otherwise
     */
    public function rememberLogin() {
        $token = new Token();
        $hashed_token = $token->getHash();
        $this->remember_token = $token->getValue();
        
        $this->expiry_timestamp = time() + 60 * 60 * 24 * 30; // 30 days from now
        
        $sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at)
                VALUES (:token_hash, :user_id, :expires_at)';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    /**
     * Send password reset instructions to the user specified
     * 
     * @param string @email The email address
     * 
     * @return void
     */
    public static function sendPasswordReset($email) {
        $user = static::findByEmail($email);        
        if ($user) {
            if (static::emailExists($email)) {
                if ($user->startPasswordReset()){
                    $user->sendPasswordResetEmail();
                    return TRUE;
                }
            } else {
                \App\Flash::addMessage('That email does not exist', \App\Flash::WARNING);
                \Core\View::render('Password/forgot.php');
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    /**
     * Start the password reset process by generating a new token and expiry
     * 
     * @return void
     */
    protected function startPasswordReset() {
        $token = new Token();
        $hashed_token = $token->getHash();
        $this->password_reset_token = $token->getValue();
        
        $expiry_timestamp = time() + 60 * 60 * 2; // Password reset lasts 2 hours
        
        $sql = 'UPDATE users'
                . ' SET password_reset_hash = :token_hash,'
                . ' password_reset_expires_at = :expires_at'
                . ' WHERE id = :id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Send password reset instructions in an email to the user
     * 
     * @return void
     */
    protected function sendPasswordResetEmail() {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . \App\Config::SITE_NAME . '/password/reset/' . $this->password_reset_token;
        
        $text = "Please click on the following URL to reset your password: $url";
        $html = "Please click <a href=\"$url\">here</a> to reset your password.";
        
        Mail::send($this->email, 'Password reset', $text, $html);
    }
    
    /**
     * Find a user by their password reset token and expiry
     * 
     * @param string $token Password reset token sent to user
     * 
     * @return mixed User object if found and the token hasn't expired, null otherwise
     */
    public static function findByPasswordReset($token) {
        $token = new Token($token);
        $hashed_token = $token->getHash();
        
        $sql = 'SELECT * FROM users'
                . ' WHERE password_reset_hash = :token_hash';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        
        $user = $stmt->fetch();
        
        if ($user) {
            // Check that the token hasn't expired
            if (strtotime($user->password_reset_expires_at) > time()) {
                return $user;
            }
        }
    }
    
    /**
     * Reset the password
     * 
     * @param string $password The new password
     * 
     * @return boolean True if the password was updated successfully, fals otherwise
     */
    public function resetPassword($password) {
        $this->password = $password;
        
        $this->validate();
        
        if (empty($this->errors)) {
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            
            $sql = 'UPDATE users'
                    . ' SET password_hash = :password_hash,'
                    . ' password_reset_hash = NULL,'
                    . ' password_reset_expires_at = NULL'
                    . ' WHERE id = :id';
            
            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue('password_hash', $password_hash, PDO::PARAM_STR);
            
            return $stmt->execute();
        }
        
        return FALSE;
    }
    
    /**
     * Send password activation email to the user
     * 
     * @return void
     */
    public function sendActivationEmail() {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . \App\Config::SITE_NAME . '/signup/activate/' . $this->activation_token;
        
        $text = "Please click on the following URL to activate your account: $url";
        $html = "Please click <a href=\"$url\">here</a> to activate your account.";
        
        Mail::send($this->email, 'Account activation', $text, $html);
    }
    
    /**
     * Activate the user account with the specified activation token
     * 
     * @param string $value Activation token from the URL
     * 
     * @return void
     */
    public static function activate($value) {
        $token = new Token($value);
        $hashed_token = $token->getHash();
        
        $sql = 'UPDATE users'
                . ' SET is_active = 1,'
                . ' activation_hash = NULL'
                . ' WHERE activation_hash = :hashed_token';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);
        
        $stmt->execute();
    }
    
    /**
     * Update the user's profile
     * 
     * @param array $data Data from the edit profile form
     * 
     * @return boolean True if the data was updated, false otherwise
     */
    public function updateProfile($data) {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->storeNumber = $data['storeNumber'];
        
        // Only validate and update the password if a value is provided
        if ($data['password'] != '') {
            $this->password = $data['password'];
        }
        
        
        $this->validate();
        
        if (empty($this->errors)) {
            $sql = 'UPDATE users'
                    . ' SET name = :name,'
                    . ' email = :email,';
            
            // Add the password if it is set
            if (isset($this->password)) {
                $sql .= ' password_hash = :password_hash,';
            }
                    $sql .= ' storeNumber = :storeNumber'
                    . ' WHERE id = :id';
            
            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':storeNumber', $this->storeNumber, PDO::PARAM_INT);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            
            // bind the password if it is set
            if (isset($this->password)) {
                $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            }
            
            return $stmt->execute();
        }
        return FALSE;
    }
}