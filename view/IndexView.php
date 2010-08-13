<?php

require_once 'View.php';

class IndexView extends View
{
    public function __construct()
    {
        parent::__construct();

        $this->requiredVars['Site']          = self::MANDATORY_VAR;
        $this->requiredVars['HeaderView']    = self::MANDATORY_VAR;
        $this->requiredVars['UserBarView']   = self::MANDATORY_VAR;
        $this->requiredVars['CacheListView'] = self::MANDATORY_VAR;
        $this->requiredVars['FooterView']    = self::MANDATORY_VAR;
    }
}
