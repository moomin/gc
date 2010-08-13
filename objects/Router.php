<?php

class Router
{
    private $controller;
    private $method;

    public function __construct()
    {
        $this->controller = ucfirst($this->getRequestParam('module', 'index'));
        $this->method = $this->getRequestParam('method', 'index');

        unset($_GET['module'], $_GET['method']);
    }

    //init error handler, logger, whatever
    public function init()
    {


    }

    public function run()
    {
        if ((include_once 'Controller.php') &&
            (include_once $this->controller.".php") &&
            class_exists($this->controller) &&
            ($c = new $this->controller) &&
            $c instanceof ControllerBase)
        {
            Site::getInstance()->getTranslations();

            $c->get = $_GET;
            $c->post = isset($_POST) ? $_POST : array();
            $c->args = array_merge($c->get, $c->post);

            if (!$c->doAction($this->method))
            {
                include_once 'Index.php';
                $index = new Index;
                $index->index();
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
