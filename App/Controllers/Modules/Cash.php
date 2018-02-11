<?php

namespace App\Controllers\Modules;

use Core\View;
use App\Models\Cash_m;
use App\Models\Helpers;
use App\Flash;
/**
 * Cash controller
 * 
 * PHP version 5.5
 */
class Cash extends \App\Controllers\Authenticated
{
    protected $bills = array();
    
    protected $coins = array();
    
    protected $propane = array();
    

    
    private $user = array();


    public function __construct() {
        // get the current user to get their store number.
        $this->user = \App\Auth::getUser();
        
        // Pull old data
        // bills first
        $this->bills = Cash_m::getMoney('bills', $this->user->storeNumber);
        
        // Coins next
        $this->coins = Cash_m::getMoney('coins', $this->user->storeNumber);
        
        // Finally propane
        $this->propane = Cash_m::getMoney('propane', $this->user->storeNumber);
    }
    /**
     * Before filter
     * 
     * @return void
     */
    protected function before() {
        // Make sure the user is logged in
        parent::before();
    }
    
    /**
     * Show the index page
     * 
     * @return void
     */
    public function indexAction() {
        View::render('Cash/index.php', array(
            'user'      => $this->user,
            'bills'     => $this->bills[0],
            'coins'     => $this->coins[0],
            'propane'   => $this->propane[0]
        ));
        
    }
    
    /**
     * Save the Cash form
     * 
     * @return void
     */
    public function saveAction() {  
        $data = isset($_POST)? $_POST : NULL;
        
        if (Cash_m::save($data)){
            Flash::addMessage('Update successfull', Flash::SUCCESS);
            $this->indexAction();
        } else {
            echo 'update failed';
            exit();
        }
    }
}