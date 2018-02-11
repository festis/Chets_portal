<?php
namespace App\Controllers\Modules;

use Core\View;
use App\Auth;
use App\Models\Helpers;
use App\Flash;
use App\Models\Disposal_m;

/**
 * Purchasing controller
 * 
 * PHP version 5.5
 */
class Disposal extends \App\Controllers\Authenticated
{
    /*
     * array to hold the user information
     */
    private $user = array();
    
     /**
     * Class constructor
     */
    public function __construct() {
        $this->user = Auth::getUser();
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
        // Get a list of the stores for dropdown
        $stores = Helpers::getStores();
        $fromStore = $this->user->storeNumber;
        View::render('Disposal/index.php', array(
            'stores' => $stores,
            'fromStore' => $fromStore
        ));
    }
    
    public function createAction() {
        $data = isset($_POST)?$_POST : NULL;
        if (!Disposal_m::sendEmail($data)) {
            Disposal_m::saveDisposal($data);
            Flash::addMessage('Request submitted successfully', Flash::SUCCESS);
            $this->indexAction();
        } else {
            exit('email failed');
        }
    }
}