<?php

require_once 'SiteController.php';
require_once 'User.php';

class SignOutController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function defaultAction()
    {
        unset($_SESSION);
        if (session_id())
        {
            setcookie(session_name(), '');
            session_destroy();
            session_write_close();
        }

        return $this->redirect($this->site->getUrl('site'),
                               'homepage',
                               5,
                               'you have been successfully signed out');
    }
}
