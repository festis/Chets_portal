<?php
/**
 * Front Controller
 * 
 * PHP version 5.5
 */
ini_set('session.cookie_lifetime', '43200'); // 12 hours in seconds
// Bring in support for PHP7 function random_bytes()
// we use this for generating random strings and hashes
require_once 'vendor/random_compat/lib/random.php';
// Bring in support for PHP7 function password functions

require_once 'vendor/password_compat/password.php';
/** ----------------------------------------------------------------------------
* Retro fit for missing http_response_code()
*/ 
if (!function_exists('http_response_code')) {
        function http_response_code($code = NULL) {

            if ($code !== NULL) {

                switch ($code) {
                    case 100: $text = 'Continue'; break;
                    case 101: $text = 'Switching Protocols'; break;
                    case 200: $text = 'OK'; break;
                    case 201: $text = 'Created'; break;
                    case 202: $text = 'Accepted'; break;
                    case 203: $text = 'Non-Authoritative Information'; break;
                    case 204: $text = 'No Content'; break;
                    case 205: $text = 'Reset Content'; break;
                    case 206: $text = 'Partial Content'; break;
                    case 300: $text = 'Multiple Choices'; break;
                    case 301: $text = 'Moved Permanently'; break;
                    case 302: $text = 'Moved Temporarily'; break;
                    case 303: $text = 'See Other'; break;
                    case 304: $text = 'Not Modified'; break;
                    case 305: $text = 'Use Proxy'; break;
                    case 400: $text = 'Bad Request'; break;
                    case 401: $text = 'Unauthorized'; break;
                    case 402: $text = 'Payment Required'; break;
                    case 403: $text = 'Forbidden'; break;
                    case 404: $text = 'Not Found'; break;
                    case 405: $text = 'Method Not Allowed'; break;
                    case 406: $text = 'Not Acceptable'; break;
                    case 407: $text = 'Proxy Authentication Required'; break;
                    case 408: $text = 'Request Time-out'; break;
                    case 409: $text = 'Conflict'; break;
                    case 410: $text = 'Gone'; break;
                    case 411: $text = 'Length Required'; break;
                    case 412: $text = 'Precondition Failed'; break;
                    case 413: $text = 'Request Entity Too Large'; break;
                    case 414: $text = 'Request-URI Too Large'; break;
                    case 415: $text = 'Unsupported Media Type'; break;
                    case 500: $text = 'Internal Server Error'; break;
                    case 501: $text = 'Not Implemented'; break;
                    case 502: $text = 'Bad Gateway'; break;
                    case 503: $text = 'Service Unavailable'; break;
                    case 504: $text = 'Gateway Time-out'; break;
                    case 505: $text = 'HTTP Version not supported'; break;
                    default:
                        exit('Unknown http status code "' . htmlentities($code) . '"');
                    break;
                }

                $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

                //header($protocol . ' ' . $code . ' ' . $text);

                $GLOBALS['http_response_code'] = $code;

            } else {

                $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

            }

            return $code;

        }
    }
    // end retrofit ------------------------------------------------------------
/**
 * Autoloader
 */
spl_autoload_register(function ($class) {
    $root = dirname(__FILE__); // get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require_once $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});
/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');
/**
 * Initialize the session
 */
session_start();
/**
 * Initialize the config file
 */
$config = new App\Config();
/**
 * Bring in email support
 */
require 'vendor/Mailer/PHPMailerAutoload.php';
/**
 * Routing
 */
$router = new Core\Router();
// Add the routes
$router->add('', array('controller' => 'Home', 'action' => 'index'));
$router->add('login', array('controller' => 'Login', 'action' => 'new'));
$router->add('logout', array('controller' => 'Login', 'action' => 'destroy'));
$router->add('{controller}/{action}');
$router->add('admin/{controller}/{action}', array('namespace' => 'Admin'));
$router->add('modules/{controller}/{action}', array('namespace' => 'Modules'));
$router->add('modules/{controller}/{id:\d+}/{action}', array('namespace' => 'Modules'));
$router->add('password/reset/{token:[\da-f]+}', array('controller' => 'Password', 'action' => 'reset'));
$router->add('signup/activate/{token:[\da-f]+}', array('controller' => 'Signup', 'action' => 'activate'));
$router->add('{controller}/{id:\d+}/{action}');
/**
 * Matching the requested URL to it's route if it has one
 */
// First get the URL
$url = $_SERVER['QUERY_STRING'];
// Remove the 'index.php' and 'index.php&' from the URL string
$url = str_replace('index.php&', '', $url);
$url = str_replace('index.php', '', $url);
defined('ROOT') or define('ROOT', dirname(__FILE__));
define("HTTP", '/'.\App\Config::SITE_NAME);
// Display the Page
$router->dispatch($url);