<?php

class User
{
    const AUTH_RES_NONE = 1;
    const AUTH_RES_OK = 2;
    const AUTH_RES_FAIL = 3;
    const AUTH_RES_CANCEL = 43;

    public $name = '';
    public $authResult = self::AUTH_RES_NONE;

    public function __construct()
    {
        if (isset($_SESSION['user']))
        {
            $this->name = $_SESSION['user'];
            $this->authResult = self::AUTH_RES_OK;
        }
    }

    public function setAuthResult($authResult)
    {
        $this->authResult = $authResult;
    }

    public function isSignedIn()
    {
        return $this->authResult == self::AUTH_RES_OK;
    }

}