<?php

require_once 'Controller.php';
require_once 'IndexView.php';
require_once 'HeaderView.php';
require_once 'UserBarView.php';

class Index extends ControllerBase
{
    public function __construct()
    {
    }

    public function index()
    {
        $view = new IndexView;

        $view->set(Site::getInstance());
        $view->set(new HeaderView());
        $view->set(new UserBarView());
        $view->set('CacheListView', new View('CacheListView.tpl'));
        $view->set('FooterView', new View('FooterView.tpl'));

        $view->display();
        return true;
    }
}

