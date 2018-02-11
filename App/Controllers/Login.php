<?php

namespace App\Controllers;
use Core\View;
use App\Models\User;
use App\Auth;
use App\Flash;
/**
 * Login controller
 * 
 * PHP version 5.5
 */
class Login extends \Core\Controller
{
    /**
     * Show the login page
     * 
     * @return void
     */
    public function newAction() {
        View::render('Login/new.php');
    }
    
    /**
     * Log a user in
     * 
     * @return void
     */
    public function createAction() {
        $user = User::authenticate($_POST['email'], $_POST['password']);
        
        $remember_me = isset($_POST['remember_me'])? $_POST['remember_me'] : NULL;
        
        if ($user) {
            Auth::login($user, $remember_me);
            
            Flash::addMessage('Login Successful');
            $this->redirect(Auth::getReturnToPage());
        } else {
            Flash::addMessage('Login unsccessful, Please try again', Flash::WARNING);
            
            View::render('Login/new.php',
            array(
                // Send the supplied email to the view on a failed login attempt
                'email' => $_POST['email'],
                'remember_me' => $remember_me
            ));
        }
    }
    
    /**
     * Log out a user
     * 
     * @return void
     */
    public function destroyAction() {
        Auth::logout();
        $this->redirect('/' . \App\Config::SITE_NAME . '/login/show-logout-message');
    }
    
    public function showLogoutMessageAction() {
        Flash::addMessage('You have successfully logged out');
        $this->redirect('/' . \App\Config::SITE_NAME);
    }
}