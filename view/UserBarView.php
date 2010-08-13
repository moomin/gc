<?php

require_once 'View.php';

class UserBarView extends View
{
    public function __construct()
    {
        parent::__construct();

        $this->requiredVars['Site'] = self::MANDATORY_VAR;
    }
}