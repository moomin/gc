<?php

class Site
{
    private static $instance = null;
    const URL_MODE_SIMPLE = 1;
    const URL_MODE_REWRITE = 2;

    private $headers = array();
    private $urlMode = self::URL_MODE_SIMPLE;
    private $urlPrefix = '/';
    public $title;
    public $debug;
    public $text;
    public $user;
    public $html;

    private function __construct()
    {
        if (isset($_COOKIE['PHPSESSID']))
        {
            session_start();
        }
    }

    private function __clone()
    {
    }

    public function init($config)
    {
        $this->title = $config['title'];
        $this->debug = $config['debug'];
        $this->setUrlPrefix($config['url_prefix']);
        return true;
    }

    public function setUrlMode($mode)
    {
        if (in_array($mode, array(self::URL_MODE_SIMPLE,
                                  self::URL_MODE_REWRITE)))
        {
            $this->urlMode = $mode;
            return true;
        }

        return false;
    }

    public function setUrlPrefix($prefix)
    {
        $this->urlPrefix = $prefix . (substr($prefix, -1) != '/' ? '/' : '');
        return true;
    }

    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new Site;
        }

        return self::$instance;
    }

    public function addHeader($tag, $value = false, $attributes = array())
    {
        $this->headers[] = array('tag' => $tag,
                                 'value' => $value,
                                 'attributes' => $attributes);
        return true;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getTranslations($module = false, $method = false)
    {
        $t = new GetText;
        $t->hello = 'Hello';
        $t->openid = 'OpenID';
        $t->signin = 'Sign In';
        $t->signout = 'Sign Out';
        $t->signinfailed = 'Failed to authorize you';
        $t->signincancel = 'You canceled authorization';

        $t->addCache = 'Add cache';
        $t->myCaches = 'My caches';
        $t->Preferences = 'Preferences';

        $t->cacheTitle = 'Title';
        $t->latitude = 'Latitude';
        $t->longtitude = 'Longtitude';
        $t->cacheBirthDate = 'The date cache was set on';
        $t->cacheDescription = 'Contents';
        $t->locationDescription = 'Location description';
        $t->submitCache = 'Submit';

        $this->text = $t;
    }

    public function getUrl($module, $method = '', $arguments = array(), $full = false)
    {
        $url = $full ? (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] : '';
        $url .= $this->urlPrefix;

        if ($module == 'index' && $method == '')
        {
            return $url;
        }

        if ($this->urlMode == self::URL_MODE_SIMPLE)
        {
            $url .= '?';
            $argSeparator = '&';
            $valueSeparator = '=';

            $additionalArguments['module'] = $module;
            if ($method != '')
            {
                $additionalArguments['method'] = $method;
            }

            $arguments = array_merge($additionalArguments, $arguments);
        }
        else
        {
            $argSeparator = '/';
            $valueSeparator = '/';
            $url .= $module . '/';
            $url .= (($method == '') && $arguments) ? 'show/' : '';
            $url .= ($method != '') ? $method . '/' : '';
        }

        $argumentsNumber = 0;

        foreach ($arguments as $argName => $argValue)
        {
            $url .= ($argumentsNumber ? $argSeparator : '') . $argName .$valueSeparator. $argValue;
            $argumentsNumber++;
        }

        return $url;
    }
}

