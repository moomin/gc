<?php

//configuration variables
$cfg = array();

//debug mode
$cfg['debug'] = true;

//path where all code files reside
$cfg['codedir'] = dirname(__FILE__);

//prefix for URL in case site is located not on a root level
$cfg['url_prefix'] = '/~dusoft/gc/';

//site title that will appear in <title> tag
$cfg['title'] = 'gc.deathbed.org.ua';

//maximum depth of view dependencies
$cfg['max_view_depth'] = 100;

//storage information
$cfg['storage_type'] = 'mysql';
$cfg['storage']['host'] = 'localhost';
$cfg['storage']['db']   = 'gc';
$cfg['storage']['user'] = 'gc';
$cfg['storage']['pass'] = 'qwerty';
