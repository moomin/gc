<?php

class View
{
    const OPTIONAL_VAR = 1;
    const MANDATORY_VAR = 2;

    private $vars = array();
    private $file;
    protected $fileExtension = '.tpl';
    protected $requiredVars = array();

    public function __construct($file = null, $data = null, $display = false)
    {
        //if no template file name given then use own class name as a name
        if ($file === null)
        {
            $file = get_class($this) . $this->fileExtension;
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
        //if object is passed as name then use it's class name as var name and
        //assign the object to $value, and then go further with standard flow
        if (is_object($name))
        {
            $value = $name;
            $name = get_class($name);
        }

        //don't add ourself to avoid endless recursion during fetch
        if ($value === $this)
        {
            return false;
        }

        //if $name is an array then recuresively call myself with
        //array's element index as first arg and value as second
        if (is_array($name))
        {
            foreach ($name as $curr_name => $curr_value)
            {
                $this->set($curr_name, $curr_value);
            }
        }
        //if $name is not an array then simply assign the value
        else
        {
            $this->vars[$name] = $value;
        }
    }

    /**
     * Opens, parses, and returns the template file.
     */
    function fetch()
    {
        //throw an exception in case any mandatory variable is missing
        foreach ($this->requiredVars as $name => $mode)
        {
            if (($mode == self::MANDATORY_VAR) &&
                !isset($this->vars[$name]))
            {
                throw new Exception(get_class($this)
                                    .'('.$this->file
                                    .'): mandatory variable '
                                    .$name
                                    .' is not set');
            }
        }

        //replace View objects with their fetching results
        foreach ($this->vars as $name => &$value)
        {
            //if $value is an instance of View class then replace it with fetch result
            if (is_object($value) && $value instanceof View)
            {
                //pass all our variables to child View
                //@todo probably it is better to request required vars and assign only them
                //instead of trying to add every object
                foreach (array_keys($this->vars) as $varName)
                {
                    //don't pass itself
                    if ($varName == get_class($value))
                    {
                        continue;
                    }

                    $value->set($varName, $this->vars[$varName]);
                }

                $value = $value->fetch();
            }
        }

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
