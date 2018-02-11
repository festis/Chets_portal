<?php

namespace App\Controllers\Admin;

/**
 * User admin controller
 * 
 * PHP version 5.5
 */
class Users extends \Core\Controller
{
    /**
     * Before filter
     * 
     * @return void
     */
    protected function before() {
        // Make sure the user is logged in, for example
        // return FALSE;
    }
    
    /**
     * Show the index page
     * 
     * @return void
     */
    public function indexAction() {
        echo 'User admin index';
    }
}