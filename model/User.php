<?php

class User
{
    const AUTH_RES_NONE = 1;
    const AUTH_RES_OK = 2;
    const AUTH_RES_FAIL = 3;
    const AUTH_RES_CANCEL = 4;

    public $name = '';
    public $authResult = self::AUTH_RES_NONE;
    public $languageId = 1;
    public $timezoneId = 1;

    public function __construct()
    {
    }

    public function signIn($name)
    {
        $this->name = $name;
        $this->authResult = self::AUTH_RES_OK;
    }

    public function setAuthResult($result)
    {
        $this->authResult = $result;
    }

    public function isSignedIn()
    {
        return $this->authResult == self::AUTH_RES_OK;
    }

}