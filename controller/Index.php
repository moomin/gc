<?php

require_once 'Controller.php';
require_once 'IndexView.php';

class Index extends ControllerBase
{
    public function __construct()
    {
    }

    public function index()
    {
        $view = new IndexView;
        $view->display();
        return true;
    }
}

