<?php

namespace Samu\TodoList\Controllers;

abstract 
class ViewController
{
    function renderView(string $path, array $variables) : string
    {
        extract($variables);

        ob_start();
        require __DIR__.'/../../view/'.$path.'.html';

        return ob_get_clean();
    }
}
    
