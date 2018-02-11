<?php

namespace App\Controllers;

/**
 * Authenticated base controller
 * 
 * PHP version 5.5
 */
abstract class Authenticated extends \Core\Controller
{
    /**
     * Require the user to be authenticated before giving access to all methods
     * in the controller. AKA action filter
     * this will run on every method in this class with the suffex Action on it
     * 
     * @return void
     */
    protected function before() {
        $this->requireLogin();
    }
}