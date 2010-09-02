<?php

class Router
{
    private $controller;
    private $method;

    public function __construct()
    {
        $this->controller = ucfirst($this->getRequestParam('module', 'site')) . 'Controller';
        $this->method = $this->getRequestParam('method', 'defaultAction');

        unset($_GET['module'], $_GET['method']);
    }

    //init error handler, logger, whatever
    public function init()
    {


    }

    public function run()
    {
        if ((include_once $this->controller.".php") &&
            class_exists($this->controller) &&
            ($c = new $this->controller) &&
            $c instanceof SiteController)
        {
            Site::getInstance()->getTranslations();

            if (!is_callable(array($c, $this->method)) ||
                !call_user_func(array($c, $this->method)))
            {
                include_once 'SiteController.php';
                $siteController = new SiteController;
                $siteController->defaultAction();
            }
        }
        else
        {
            throw new Exception('controller not found');
        }

        return true;
    }

    private function getRequestParam($name, $default = null)
    {
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
    }

}
