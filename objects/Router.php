<?php

class Router
{
    private $controller;
    private $method;

    public function __construct()
    {
        $controller = isset($_REQUEST['module']) ? $_REQUEST['module'] : 'site';

        $this->controller = ucfirst($controller) . 'Controller';
        $this->method = isset($_REQUEST['method']) ? $_REQUEST['method'] : 'defaultAction';;

        unset($_GET['module'], $_GET['method']);
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

}
