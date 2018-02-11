<?php

namespace Core;

/**
 * View
 * 
 * PHP verdion 5.5
 */
class View
{
    /**
     * Render a view file
     * 
     * @param string $view The view file
     * 
     * @return void
     */
    public static function render($view, $args = array())
    {
        extract($args, EXTR_SKIP);
        $file = "App/Views/$view"; // Relative to the core directory
        
        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }
}