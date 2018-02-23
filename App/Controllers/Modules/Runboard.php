<?php

namespace App\Controllers\Modules;

use Core\View;
use App\Auth;
use App\Models\Runboard_m;
use App\Flash;
use App\Models\Helpers;

/**
 * Runboard controller
 * 
 * PHP version 5.5
 */
class Runboard extends \App\Controllers\Authenticated
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
        // collect the data
        $rental = Runboard_m::getByStoreIdMove($this->user->storeNumber, 'Rental Run');
        $interCompany = Runboard_m::getByStoreIdMove($this->user->storeNumber, 'Inter-company');
        $parts = Runboard_m::getByStoreIdMove($this->user->storeNumber, 'Parts');
        $other = Runboard_m::getByStoreIdMove($this->user->storeNumber, 'Other');
        $notOwn = Runboard_m::getByStoreNotOwn($this->user->storeNumber);
        View::render('Runboard/index.php', array(
            'username' => $this->user->name,
            'rental' => $rental,
            'interCompany' => $interCompany,
            'parts' => $parts,
            'other' => $other,
            'notOwn' => $notOwn 
        ));
    }
    
    /**
     * Show the All Runs page
     * 
     * @return void
     */
    public function allrunsAction() {
        // collect the data
        
        $rental = Runboard_m::getAllByMove('Rental Run');
        $interCompany = Runboard_m::getAllByMove('Inter-company');
        $parts = Runboard_m::getAllByMove('Parts');
        $other = Runboard_m::getAllByMove('Other');
        
        View::render('Runboard/allruns.php', array(
            'username' => $this->user->name,
            'rental' => $rental,
            'interCompany' => $interCompany,
            'parts' => $parts,
            'other' => $other
        ));
    } 
    
    /**
     * Show the On Rent Runs page
     * 
     * @return void
     */
    public function onrentAction() {
        // Collect the data
        $data = Runboard_m::getByStatus('On-Rent');

        View::render('Runboard/status.php', array(
            'data' => $data
        ));
    }
    
    /**
     * Show the Repair page
     * 
     * @return void
     */
    public function repairAction() {
        // Collect the data
        $data = Runboard_m::getByStatus('Repair');

        View::render('Runboard/status.php', array(
            'data' => $data
        ));
    }
    
    /**
     * Show the movement page
     * 
     * @return void
     */
    public function movementAction() {
        // get a list of the stores
        $stores = Helpers::getStores();
        
        View::render('Runboard/movement.php', array(
            'stores' => $stores
        ));
    }
    
    /**
     * Displays the requested movement page based on from store and to store supplied
     * 
     * @return void
     */
    public function movementDisplayAction() {
        $fromStore = isset($_POST['fromStore'])? $_POST['fromStore']: NULL;
        $toStore = isset($_POST['toStore'])? $_POST['toStore']: NULL;;
        
        $data = Runboard_m::getByMovement($fromStore, $toStore);
        
        View::render('Runboard/movementDisplay.php', array(
            'data' => $data
        ));
    }
    
    /**
     * Show the Long Term page
     * 
     * @return void
     */
    public function longtermAction() {
        // Collect the data
        $data = Runboard_m::getByStatus('Long-Term');

        View::render('Runboard/status.php', array(
            'data' => $data
        ));
    }
    
    /**
     * Show the Add run page
     * 
     * @param $edit array run data for editing
     * @param $exists boolean whether or not the record already exists
     * 
     * @return void
     */
    public function addrunAction($edit = NULL, $exists = FALSE) {        
        // get a list of the stores
        $stores = Helpers::getStores();
        
        // get a list of the run types
        $types = Runboard_m::getTypes();
        
        // get a list of the item statuses
        $statuses = Runboard_m::getStatus();
        
        // Add an edit flag to update rather than add a new one
        ($edit!=NULL)? $update = TRUE : $update = FALSE;
        
        
        View::render('Runboard/addrun.php', array(
            'exists' => $exists,
            'update' => $update,
            'transID' => isset($edit[0]['transID'])? $edit[0]['transID']: NULL,
            'fromStore' => isset($edit[0]['fromStore'])? $edit[0]['fromStore']: NULL,
            'toStore' => isset($edit[0]['toStore'])? $edit[0]['toStore']: NULL,
            'category' => isset($edit[0]['category'])? $edit[0]['category']: NULL,
            'item' => isset($edit[0]['item'])? $edit[0]['item']: NULL,
            'description' => isset($edit[0]['description'])? $edit[0]['description']: NULL,
            'dateNeeded' => isset($edit[0]['dateNeeded'])? $edit[0]['dateNeeded']: NULL,
            'runType' => isset($edit[0]['movementType'])? $edit[0]['movementType']: NULL,
            'timeNeeded' => isset($edit[0]['timeNeeded'])? $edit[0]['timeNeeded']: NULL,
            'itemStatus' => isset($edit[0]['itemStatus'])? $edit[0]['itemStatus']: NULL,
            'notes' => isset($edit[0]['notes'])? $edit[0]['notes']: NULL,
            'stores' => $stores,
            'types' => $types,
            'statuses' => $statuses
        ));
    }
    
    /**
     * Add a new run into the Database
     * 
     * @return void
     */
    public function createAction() {
        if (isset($_POST)) {
            $run = new Runboard_m($_POST);
            // Check to see if the run is already in the db, but only once
                if ($_POST['exists'] == FALSE){
                    if ($exists = $run->runExists()) {
                        Flash::addMessage('That run already exists', Flash::WARNING);
                        $this->addRunAction($exists, TRUE);
                        exit();
                    }
                }
            
            if ($run->save($this->user->storeNumber, $_POST['update'])) {
                Flash::addMessage('success', Flash::SUCCESS);
            } else {
                Flash::addMessage('unsccessful', Flash::WARNING);
            }
            $this->redirect('/' . \App\Config::SITE_NAME . '/modules/runboard/index');
        } else {
            Flash::addMessage('unsccessful', Flash::WARNING);
            $this->redirect('/' . \App\Config::SITE_NAME . '/modules/runboard/index');
        }
    }
    
    /**
     * Edit an existing run
     * 
     * @return void
     */
    public function editAction() {
        // parse out the ID from the URL    
        $transID = Helpers::parseId();

        // Get the record needed for editing based on the transID
        $record = Runboard_m::getById($transID);

        $this->addrunAction($record, TRUE);
    }

        /**
     * Delete a record
     * 
     * @return void
     */
    public function deleteAction() {
        if (isset($_POST['delete'])) {
            
            //$id = $_POST['trans'];
            $id = isset($_POST['checkbox']);
            
            if (Runboard_m::delete($id)) {
                Flash::addMessage('Deletion sccessful', Flash::SUCCESS);
            } else {
                Flash::addMessage('Deletion unsccessful', Flash::WARNING);
            }
        } else {
            Flash::addMessage('Deletion unsccessful', Flash::WARNING);
        }
        
        $this->redirect('/' . \App\Config::SITE_NAME . '/modules/runboard/index');
    }
}