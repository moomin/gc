<?php

include_once './config.php';

set_include_path($cfg['codedir'] . '/objects:' .
                 $cfg['codedir'] . '/model:' .
                 $cfg['codedir'] . '/view:' .
                 $cfg['codedir'] . '/controller:' .
                 $cfg['codedir'] . '/templates');

require_once 'Router.php';
require_once 'Site.php';
require_once 'GetText.php';
require_once 'User.php';
require_once 'Html.php';

try
{
    //initialize site
    $site = Site::getInstance();
    $site->title = $cfg['title'];
    $site->debug = $cfg['debug'];
    $site->setUrlPrefix($cfg['url_prefix']);

    $site->addHeader('meta', false, array('http-equiv' => 'Content-Type', 'content' => 'text/html; charset=utf-8'));

    $site->user = new User;
    $site->html = new Html;

    define('MAX_VIEW_DEPTH', isset($cfg['max_view_depth']) ? $cfg['max_view_depth'] : 100);
    unset($cfg);

    //initialize and run router
    $router = new Router;

    $router->init();
    $router->run();
}
catch(Exception $e)
{
    header('Content-Type: text/plain');

    echo "Something went wrong, sorry. Try again later.\n";
    if ($site->debug)
    {
        echo 'Exception caught: '.$e->getMessage();
    }
}