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
        $text = new GetText;
        $text->hello = 'Hello';
        $text->openid = 'OpenID';
        $text->signin = 'Sign In';
        $text->signout = 'Sign Out';
        $text->signinfailed = 'Failed to authorize you';
        $text->signincancel = 'You canceled authorization';

        $this->text = $text;
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

