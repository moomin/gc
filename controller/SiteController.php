<?php

require_once 'Site.php';
require_once 'HeaderView.php';
require_once 'UserBarView.php';

class SiteController
{
    protected $get;
    protected $post;
    protected $args;

    protected $site;
    protected $views = array();

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = isset($_POST) ? $_POST : array();
        $this->args = array_merge($this->get, $this->post);

        $this->site = Site::getInstance();
    }

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

    public function displayHead()
    {
        $header = new HeaderView();
        $header->set($this->site);
        $header->display();

        return true;
    }

    public function displayTop()
    {
        $header = new HeaderView();
        $header->set($this->site);

        $userBar = new UserBarView();
        $userBar->set($this->site);

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

    public function redirect($url, $name = false, $timeout = false, $message = false)
    {
        if (false != $name)
        {
            $redirect = new View('RedirectView.tpl');
            $redirect->txt = $this->site->text;
            $redirect->message = $message;
            $redirect->seconds = $timeout;
            $redirect->targetName = $name;
            $redirect->targetUrl = $url;

            $this->addView($redirect);
            $this->displayHead();
            $this->displayBody();
            $this->displayBottom();
        }
        else
        {
            header('Location: ' . $url);
            exit(0);
        }

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

