<?php

interface ControllerInterface
{
    public function doAction($method);
}

class ControllerBase implements ControllerInterface
{
    public $get;
    public $post;
    public $args;

    public function doAction($method)
    {
        if (is_callable(array($this, $method)))
        {
            return call_user_func(array($this, $method));
        }

        return false;
    }


}
