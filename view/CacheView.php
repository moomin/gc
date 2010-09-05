<?php

require_once 'View.php';

class CacheView extends View
{
    public function __construct()
    {
        parent::__construct();

        $this->requiredVars['Site'] = self::MANDATORY_VAR;
        $this->requiredVars['GeoCache'] = self::MANDATORY_VAR;
        $this->requiredVars['html'] = self::MANDATORY_VAR;
        $this->requiredVars['edit'] = self::MANDATORY_VAR;
    }
}
