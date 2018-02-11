<?php

namespace Core;

use App\Auth;
use App\Flash;

/**
 * Base Controller
 * 
 * PHP version 5.5
 */
abstract class Controller
{
    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = array();
    
    /**
     * Class constructor
     * 
     * @param array $route_params Parameters from the route
     * @return void
     */
    public function __construct($route_params) {
        $this->route_params = $route_params;
    }
    
    public function __call($name, $args) {
        $method = $name . 'Action';
        
        if (method_exists($this, $method)) {
            if ($this->before() !== FALSE) {
                call_user_func(array($this, $method), $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . 
                get_class($this));
        }
    }
    
    /**
     * Before filter - called before an action method
     * 
     * @return void
     */
    protected function before() {
        
    }
    
    /**
     * After filter - called after an action method.
     * 
     * return void
     */
    protected function after() {
        
    }
    
    public function redirect($url) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $url, TRUE, 303);
        exit();
    }
    
    /**
     * Requires the user to log in before giving access to the requested page
     * It also remembers the page for later, then redirects to the login page
     * Use this on in any controller that you want to require logging in
     */
    public function requireLogin() {
        if (!Auth::getUser()) {
            // Add a flash message telling the user to login first
            Flash::addMessage('Please login to access that page', Flash::INFO);
            
            // Remember the requesting page so we can come back after login
            Auth::rememberRequestedPage();
            
            // Redirect to the login page
            $this->redirect('/' . \App\Config::SITE_NAME . '/login');
        }
    }
}