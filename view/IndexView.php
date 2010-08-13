<?php

require_once 'View.php';
require_once 'HeaderView.php';
require_once 'UserBarView.php';

class IndexView extends View
{
    public function __construct()
    {
        parent::__construct();
        $site = Site::getInstance();

        $header = new HeaderView;
        $userBar = new UserBarView;
        $cacheList = new View('CacheList.tpl');
        $footer = new View('Footer.tpl');

        $header->title = $site->title;

        $this->header = $header;
        $this->footer = $footer;
        $this->set($site->html);
        $this->set('userBar', $userBar);
        $this->set('cacheList', $cacheList);
    }
}
