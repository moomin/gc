<?php

require_once 'User.php';

class SignOutController extends ControllerBase
{
    public function defaultAction()
    {
        unset($_SESSION);
        setcookie(session_name(), '');
        session_destroy();
        session_write_close();
        header('Location: ' . Site::getInstance()->getUrl('site', '', array(), true));
        exit(0);
    }
}