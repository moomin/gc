<?php

class GetText
{
    private $strings;

    public function __set($name, $value)
    {
        $this->strings[$name] = $value;
    }

    public function __get($name)
    {
        return isset($this->strings[$name]) ? $this->strings[$name] : '{'.$name.'}';
    }

    public function get($name, $args)
    {
        return vsprintf($this->$name, $args);
    }

}