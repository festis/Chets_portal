<?php
/**
 * This is the application level configuration file. This is the file where
 * users will input their own settings for their site.
 */

namespace App;

/** 
 * Application configuration
 * These are user configurable settings
 * 
 * PHP version 5.5
 */
class Config
{
    /**
     * An array to hold all the module names.
     * This is set automatically with the constructor
     *
     * @var array modules
     */
    private $modules = array();
    
    /**
     * An array to hold any custom navigation links.
     * You can add in any custom navigation links you'd like
     * The array key will be the text of the link, the array value will be the
     * URL you want it to go to. They will automatically be added to the 
     * Navigation Bar.
     * 
     * @var array nav_links
     */
    private $nav_links = array(
        'Webmail' => 'http://www.chetsrentall.com/webmail',
        'Resources' => 'http://employee.chetsrentall.com',
        'Helpdesk' => 'http://www.chetsrentall.com/helpdesk',
        'Deezers' => 'http://mywebterminal.com',
        'Webmail Lite' => 'https://chetsrentall.com/WebmailLite/'
        );
    
    
    /**
     * Site Name
     * Set this only if you are working in a subdirectory
     * ex. http://www.yoursite/sitename
     * 
     * $var string
     */
    const SITE_NAME = 'apps';
    
    /**
     * Email From Name
     * This is used to set the From attribute in the email form
     * 
     * @var string Email name
     */
    const EMAIL_NAME = "Chet's Rentall";
    
    /**
     * Database host
     * This should almost always be 'localhost'
     * 
     * @var string
     */
    const DB_HOST = 'localhost';
    
    /**
     * Database name
     * 
     * @var string
     */
    const DB_NAME = 'chetsren_superapp';
    
    /**
     * Database user
     * 
     * @var string
     */
    const DB_USER = 'chetsren_superap';
    
    /**
     * Database Password
     * 
     * @var string
     */
    const DB_PASSWORD = 'chets_2016';
    
    /**
     * Show or hide errors on screen
     * 
     * @var boolean
     */
    const SHOW_ERRORS = TRUE;
    
    /**
     * Secret key for hashing
     * 
     * @var string
     */
    const SECRET_KEY = '0vhcvP0iQaYfL76PTRt1L3SSP9Vav2i9';
    
    /**
     * Email username
     * This is the email address that will be used to send mail from
     * 
     * @var string
     */
    const EMAIL_USER = 'chets.purchasing@gmail.com';
    
    /**
     * Email Password
     * 
     * @var string
     */
    const EMAIL_PASS = 'chets123';
    
    public function __construct() {
        // Get module names for navigation
        $dir = getcwd() . '/App/Controllers/Modules';
        $modules = array_slice(scandir($dir), 2);
        foreach ($modules as $module) {
            $module = str_replace('.php', '', $module);
            $this->modules[] = $module;
        }
    }
    
    /**
     * 
     * @return string
     */
    public function getModules() {
        return $this->modules;
    }
    
    public function getNav_links() {
        return $this->nav_links;
    }
}
