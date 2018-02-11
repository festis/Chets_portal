<?php

namespace App\Controllers;

/**
 * Items controller 
 * 
 * PHP version 5.5
 */
class Items extends Authenticated
{    

    /**
     * Items index
     * 
     * @return void
     */
    public function indexAction() {
        \Core\View::render('Items/index.php');
    }
}