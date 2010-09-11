<?php

require_once 'View.php';

class FormErrorsView extends View
{
    public function __construct()
    {
        parent::__construct();

        $this->requiredVars['errors'] = self::OPTIONAL_VAR;
    }
}
