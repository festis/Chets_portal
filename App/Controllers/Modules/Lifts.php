<?php

namespace App\Controllers\Modules;

use Core\View;
use App\Models\Lift_m;
use App\Models\Helpers;
use App\Flash;

/**
 * Lifts controller
 * 
 * PHP version 5.5
 */
class Lifts extends \App\Controllers\Authenticated
{
    private $user = array();
    /**
     * Before filter
     * 
     * @return void
     */
    public function __construct() {
        $this->user = \App\Auth::getUser();
    }
    
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
        // Get the overdue lifts
        $overdue = Lift_m::getoverdue();

        View::render('Lifts/index.php', array(
            'lifts' => $overdue,
            'pageName' => 'Overdue Lifts',
            'user' => $this->user
        ));
    }
    
    /**
     * Show specific lifts
     * 
     * @return void
     */
    private function getLifts($filter, $column, $pageName) {
        
        if ($column != NULL) {
            $lifts = Lift_m::getById($filter, $column);

            View::render('Lifts/index.php', array(
                'lifts' => $lifts,
                'pageName' => $pageName,
                'user' => $this->user
            ));
        } else {
            
        }
    }

    /**
     * Show All lifts
     *
     * @return void
     */
    private function getAllLifts($pageName) {

            $lifts = Lift_m::getAllActive();

            View::render('Lifts/index.php', array(
                'lifts' => $lifts,
                'pageName' => $pageName,
                'user' => $this->user
            ));
    }
    
    public function noviAction() {
        $this->getLifts('novi', 'inspector', "Novi's Lifts");
    }
    public function cantonAction() {
        $this->getLifts('canton', 'inspector', "Canton's Lifts");
    }
    public function waterfordAction() {
        $this->getLifts('waterford', 'inspector', "Waterford's Lifts");
    }
    public function rochesterAction() {
        $this->getLifts('rochester Hills', 'inspector', "Rochester's Lifts");
    }
    public function unassignedAction() {
        $this->getLifts('None', 'inspector', "Lifts not yet assigned");
    }
    public function allLiftAction(){
        $this->getAllLifts('All Lifts');
    }
    public function awpAction() {
        $this->getLifts('1445', 'category', "24' Aerial Work Platforms");
    }
    public function runaboutAction() {
        $this->getLifts('1446', 'category', "20' Runabout");
    }
    public function nineteenAction() {
        $this->getLifts('1450', 'category', "19' Scissor Lifts");
    }
    public function twentysixAction() {
        $this->getLifts('1451', 'category', "26' Scissor Lifts");
    }
    public function thirtytwoAction() {
        $this->getLifts('1452', 'category', "32' Scissor Lifts");
    }
    public function spFiftyAction() {
        $this->getLifts('1461', 'category', "45' and 50' All Terrain Lifts");
    }
    public function tmThirtyfourAction() {
        $this->getLifts('1462', 'category', "TM34 Boom Lifts");
    }
    public function sdFiftyAction() {
        $this->getLifts('1464', 'category', "SD50 Boom Lifts");
    }
    public function tmFiftyAction() {
        $this->getLifts('1465', 'category', "TM50 Boom Lifts");
    }
    public function tdThirtyfourAction() {
        $this->getLifts('1466', 'category', "TD34T Boom Lifts");
    }
    public function spThirtyfourAction() {
        $this->getLifts('1467', 'category', "SP34 Boom Lifts");
    }
    public function jlgSixhundredAction() {
        $this->getLifts('1468', 'category', "JLG600 Boom Lifts");
    }
    
    /**
     * Edit an existing lift inspection
     * 
     * @return void
     */
    public function editAction() {  
                   
            $transID = Helpers::parseId();

            // Get the record needed for editing based on the transID
            $record = Lift_m::getById($transID);
            
            View::render('Lifts/edit.php', array(
               'record' => $record 
            ));
    }
    
    /**
     * Update the lift database
     * 
     * @return void
     */
    public function updateAction() {  
        $data = isset($_POST)? $_POST : NULL;
        
        if (lift_m::update($data)){
            Flash::addMessage('Update successfull', Flash::SUCCESS);
            $this->indexAction();
        } else {
            echo 'update failed';
            exit();
        }
    }
    
    /**
     * Update the inspector of a lift
     * 
     * @return void
     */
    public function updateInspectorAction() {  
        $data = isset($_POST)? $_POST : NULL;
        
        if (lift_m::updateInspector($data)){
            Flash::addMessage('Inspector updated', Flash::SUCCESS);
            $this->indexAction();
        } else {
            echo 'update failed';
            exit();
        }
    }
}