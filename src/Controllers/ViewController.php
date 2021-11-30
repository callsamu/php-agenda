<?php

namespace Samu\TodoList\Controllers;

abstract
class ViewController
{
    private array $variables;
    private string $inheritor;
    private string $view;

    private $viewsDir = __DIR__.'/../../view/';

    public function getInheritorContents() : string
    {
        return $this->inheritor;
    }

    public function loadView(string $path, array $variables)
    {
        $this->view = $this->viewsDir . $path . '.html';
        $this->variables = $variables;

        return $this;
    }

    private function useView() : string 
    {
        $view = $this->view;
        unset($this->view);        

        return $view;
    }

    public function renderView() : string
    {
        extract($this->variables);

        $view = $this->useView();

        ob_start();
        require $view;
        $content = ob_get_clean();

        if (isSet($this->view)) {
            $this->inheritor = $content;
            return $this->renderView();
        }

        return $content;
    }
}

