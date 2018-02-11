<?php

namespace App\Controllers;

use Core\View;
use App\Models\Post;

/**
 * Posts Controller
 * 
 * PHP version 5.5
 */
class Posts extends \Core\Controller
{
    /**
     * Show the index page
     * 
     * @return void
     */
    public function indexAction() {
        $posts = Post::getAll();
        
        View::render('Posts/index.php', [
            'posts' => $posts
        ]);
    }
    
    public function addNewAction() {
        echo 'Hello from the addNew method in the Posts controller';
    }
    
    public function editAction() {
        echo 'Hello from the edit method in the Posts controller';
        echo '<p>Route parameters: <pre>' . 
        htmlspecialchars(print_r($this->route_params, TRUE)) . '</pre></p>';
    }
}