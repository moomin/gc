<?php

require_once 'Controller.php';
require_once 'HeaderView.php';
require_once 'UserBarView.php';

class SiteController extends ControllerBase
{
    protected $views = array();

    public function addView($view)
    {
        if ($view instanceof View)
        {
            $this->views[] = $view;
            return true;
        }

        return false;
    }

    public function defaultAction()
    {
        return $this->displayAll();
    }

    public function displayAll()
    {
        return (
            $this->displayTop() &&
            $this->displayBody() &&
            $this->displayBottom());
    }

    public function displayTop()
    {
        $site = Site::getInstance();
        
        $header = new HeaderView();
        $header->set($site);

        $userBar = new UserBarView();
        $userBar->set($site);

        $header->display();
        $userBar->display();

        return true;
    }

    public function displayBody()
    {
        foreach($this->views as $view)
        {
            if (!$view->display())
            {
                return false;
            }
        }

        return true;
    }

    public function displayBottom()
    {
        new View('FooterView.tpl', null, true);
        return true;
    }

    public function updateObject($object, $properties, $from = 'post')
    {
        if (!is_array($from))
        {
            $from = $this->$from;
        }

        foreach ($properties as $name)
        {
            if (isset($from[$name]))
            {
                $object->$name = $from[$name];
            }
        }

        return true;
    }

}

