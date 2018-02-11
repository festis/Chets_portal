<?php

namespace App\Controllers;

use Core\View;
use App\Models\User;

/**
 * Signup Controller
 * 
 * PHP version 5.5
 */
class Signup extends \Core\Controller
{
    /**
     * Show the signup page
     * 
     * @return void
     */
    public function newAction() {
        View::render('Signup/new.php');
    }
    
    /**
     * Sign up a new user
     * @return void
     */
    public function createAction() {
        $user = new User($_POST);
        
        if ($user->save()) {
            $user->sendActivationEmail();
            // upon successfull saving, we redirect to a success page
            $this->redirect('/' . \App\Config::SITE_NAME . '/signup/success');
        } else {
            View::render('Signup/new.php', array(
               'user' => $user
            ));
        }
    }
    
    /**
     * Show the signup success page
     * 
     * @return void
     */
    public function successAction() {
        /**
         * Show the signup success page
         * 
         * @return void
         */
        View::render('Signup/success.php');
    }
    
    /**
     * Activate a new account
     * 
     * @return void
     */
    public function activateAction() {
        User::activate($this->route_params['token']);
        $this->redirect('/' . \App\Config::SITE_NAME . '/signup/activated');
    }
    
    /**
     * Show the activated success page
     * 
     * @return void
     */
    public function activatedAction() {
        View::render('Signup/activated.php');
    }
}