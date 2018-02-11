<?php

namespace App\Controllers;

use Core\View;
use App\Auth;
use App\Flash;
/**
 * Profile controller
 * 
 * PHP version 5.6
 */
class Profile extends Authenticated
{
    /**
     * Before Filter - called before each action method
     * 
     * @return void
     */
    protected function before() {
        parent::before();
        $this->user = Auth::getUser();
    }

    /**
     * Show the profile
     * 
     * @return void
     */
    public function showAction() {
        View::render('Profile/show.php', array(
            'user' => $this->user
        ));
    }
    
    /**
     * Show the form for editing the profile
     * 
     * @return void
     */
    public function editAction() {
        $stores = \App\Models\Helpers::getStores();
        View::render('Profile/edit.php', array(
            'user' => $this->user,
            'stores' => $stores
        ));
    }
    
    /**
     * Update the current user's profile
     * 
     * @return void
     */
    public function updateAction() {
        
        if ($this->user->updateProfile($_POST)) {
            Flash::addMessage('Changes Saved');
            $this->redirect('/' . \App\Config::SITE_NAME . '/profile/show');            
        } else {
            $stores = \App\Models\Helpers::getStores();
            View::render('Profile/edit.php', array(
                'user' => $this->user,
                'stores' => $stores
            ));
        }
    }
}