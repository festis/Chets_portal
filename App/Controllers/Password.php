<?php

namespace App\Controllers;

use Core\View;
use App\Models\User;
/**
 * Password Controller
 * 
 * PHP version 5.6
 */
class Password extends \Core\Controller
{
    /**
     * Show the forgotten password page
     * 
     * @return void
     */
    public function forgotAction() {
        View::render('Password/forgot.php');
    }
    
    /**
     * Send the password reset link to the supplied email
     * 
     * @return void
     */
    public function requestResetAction() {
        if(User::sendPasswordReset($_POST['email'])){        
            View::render('Password/reset_requested.php');
        } else {
            \App\Flash::addMessage('That email does not exist', \App\Flash::WARNING);
            \Core\View::render('Password/forgot.php');
        }  
    }
    
    /**
     * Show the password reset form
     * 
     * @return void
     */
    public function resetAction() {
        $token = $this->route_params['token'];
        
        $user = $this->getUserOrExit($token);
        
        View::render('Password/reset.php', array(
            'token' => $token
        ));
    }
    
    /**
     * Reset the user's password
     * 
     * @return void
     */
    public function resetPasswordAction() {
        $token = $_POST['token'];
        
        $user = $this->getUserOrExit($token);
        
        if ($user->resetPassword($_POST['password'])) {
            View::render('Password/reset_success.php');
        } else {
            View::render('Password/reset.php', array(
               'token' => $token,
                'user' => $user
            )); 
        }
    }
    
    /**
     * find the user associated with the password reset token, or end the request
     * with a message
     * 
     * @param string $token Password reset token sent to user
     * 
     * @return mixed User object if found and the token hasn't expired, null otherwise
     */
    protected function getUserOrExit($token) {
        $user = User::findByPasswordReset($token);
        
        if ($user) {
            return $user;
        } else {
            View::render('Password/token_expired.php');
            exit;
        }
    }
}