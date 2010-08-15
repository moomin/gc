<?php

require_once 'View.php';

class CacheListView extends View
{
    public function __construct()
    {
        parent::__construct();

        $this->requiredVars['Site'] = self::MANDATORY_VAR;
        $this->requiredVars['caches'] = self::OPTIONAL_VAR;
    }
}
