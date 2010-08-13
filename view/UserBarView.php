<?php

class UserBarView extends View
{
    public function __construct()
    {
        parent::__construct();
        $site = Site::getInstance();

        $this->site = $site;
        $this->html = $site->html;
        $this->user = $site->user;
        $this->text = $site->text;
    }

}