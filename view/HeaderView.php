<?php

require_once 'View.php';
require_once 'Site.php';

class HeaderView extends View
{
    public function __construct()
    {
        parent::__construct();

        $site = Site::getInstance();

        $this->html = $site->html;
        $this->title = $site->title;
        $this->headers = $site->getHeaders();
    }
}