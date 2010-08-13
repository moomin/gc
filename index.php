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
    $site = Site::getInstance();
    $site->title = 'gc.deathbed.org.ua';

    $site->setUrlPrefix($cfg['url_prefix']);

    $site->addHeader('meta', false, array('http-equiv' => 'Content-Type', 'content' => 'text/html; charset=utf-8'));

    $site->user = new User;
    $site->html = new Html;

    $router = new router;
    $router->init();
    $router->run();
}
catch(Exception $e)
{
    echo "Something went wrong, sorry. Try again later.";
}