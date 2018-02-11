<?php

namespace App\Controllers;

use Core\View;
use App\Auth;

/**
 * Home Controller
 * 
 * PHP version 5.5
 */
class Home extends \Core\Controller
{
    /**
     * Before filter
     * @return void
     */
    protected function before() {
        //echo "(before) ";
        //return FALSE;
    }
    
    /**
     * After filter
     * @return void
     */
    protected function after() {
        //echo " (after)";
    }
    
    /**
     * Show the index page
     * 
     * @return void
     */
    public function indexAction() {        
        View::render('Home/index.php');
    }
    public function includes() {
        
    }
}