<?php

require_once 'Controller.php';
require_once 'User.php';

class SignOut extends ControllerBase
{
    public function index()
    {
        unset($_SESSION);
        setcookie(session_name(), '');
        session_destroy();
        session_write_close();
        header('Location: ' . Site::getInstance()->getUrl('index', '', array(), true));
        exit(0);
    }
}