<?php

include_once './config.php';

set_include_path($cfg['codedir'] . '/objects:' .
                 $cfg['codedir'] . '/model:' .
                 $cfg['codedir'] . '/view:' .
                 $cfg['codedir'] . '/controller:' .
                 $cfg['codedir'] . '/templates');

require_once 'Router.php';
require_once 'Site.php';

try
{
    define('MAX_VIEW_DEPTH', isset($cfg['max_view_depth']) ? $cfg['max_view_depth'] : 100);

    //initialize site
    $site = Site::getInstance();
    $site->init($cfg);
    unset($cfg);

    //uncomment if developing in offline
    //$site->user->signIn('Valera');

    //initialize and run router
    $router = new Router;

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
