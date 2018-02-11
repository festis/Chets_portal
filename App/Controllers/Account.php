<?php

namespace App\Controllers;

use App\Models\User;

/**
 * Account controller
 * 
 * PHP version 5.5
 */
class Account extends \Core\Controller
{
    /**
     * Validate if email is available (AJAX) for a new signup.
     * 
     * @return void
     */
    public function validateEmailAction() {
        $is_valid = !User::emailExists($_GET['email'], isset($_GET['ignore_id']) ? $_GET['ignore_id'] : NULL);
        
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }
}