<?php

class View
{
    private $vars;
    private $file;

    public function __construct($file = null, $data = null, $display = false)
    {
        if ($file === null)
        {
            $file = substr(get_class($this), 0, -strlen(get_class())) . '.tpl';
        }

        $this->file = $file;

        if ($data)
        {
            $this->set($data);
        }

        if ($display)
        {
            $this->display();
        }
    }

    function __set($name, $value)
    {
        $this->set($name, $value);
    }

    function set($name, $value = '')
    {
        if (is_object($name))
        {
            $this->vars[get_class($name)] = $name;
        }
        else if (!is_array($name))
        {
            $this->vars[$name] = $value instanceof View ? $value->fetch() : $value;
        }
        else
        {
            foreach ($name as $curr_name => $curr_value)
            {
                $this->vars[$curr_name] = $curr_value instanceof View ?
                    $curr_value->fetch() :
                    $curr_value;
            }
        }
    }

    /**
     * Opens, parses, and returns the template file.
     */
    function fetch()
    {
        if (is_array($this->vars))
        {
            extract($this->vars);      // Extract the vars to local namespace
        }

        ob_start();                    // Start output buffering

        include $this->file;           // Include template file

        $contents = ob_get_contents(); // Get the contents of the buffer

        ob_end_clean();                // End buffering and discard

        return $contents;              // Return the contents
    }

    function display()
    {
        echo $this->fetch();
    }
}
