<?php

require_once 'View.php';

class HeaderView extends View
{
    public function __construct()
    {
        parent::__construct();

        $this->requiredVars['title'] = self::MANDATORY_VAR;
        $this->requiredVars['html'] = self::MANDATORY_VAR;
        $this->requiredVars['headers'] = self::MANDATORY_VAR;
    }
}