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

    public function getRequiredVars()
    {
        return array_keys($this->requiredVars);
    }

    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    public function set($name, $value = '')
    {
        //if object is passed as name then use it's class name as var name and
        //assign the object to $value, and then go further with standard flow
        if (is_object($name))
        {
            $value = $name;
            $name = get_class($name);
        }

        //don't add myself to avoid endless recursion during fetch
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

    protected function fetchChildView($viewToFetch, $history = array())
    {
        $viewsAvailable = array();

        //replace View objects with their fetching results
        foreach (array_keys($this->vars) as $name)
        {
            //if $value is an instance of View class then replace it with fetch result
            if (is_object($this->vars[$name]) && $this->vars[$name] instanceof View)
            {
                $viewsAvailable[] = $name;
            }
        }

        //this view is already fetched
        if (!in_array($viewToFetch, $viewsAvailable) && isset($this->vars[$viewToFetch]))
        {
            return true;
        }
        //we are in recursive dependency here
        else if (in_array($viewToFetch, $history))
        {
            throw new Exception(get_class($this)
                                .'('. $this->file
                                .'): recursive dependency in views; dependency tree:'
                                .implode('->', $history)
                                .'->'
                                .$viewToFetch);
        }
        //to many recursive calls, something might be wrong
        //@todo: define a constant for this number
        elseif (count($history) > MAX_VIEW_DEPTH)
        {
            throw new Exception(get_class($this)
                                .'('. $this->file
                                .'): Wow! It\'s over 9000(actually '
                                .count($history)
                                .') recursive calls during Views dependency resolving; dependency tree:'
                                .implode('->', $history)
                                .'->'
                                .$viewToFetch);
        }

        $history[] = $viewToFetch;

        $view = $this->vars[$viewToFetch];

        $varsRequiredByView = $view->getRequiredVars();

        //assign variables required by child
        //@todo probably it is better to request required vars and assign only them
        //instead of trying to add every object
        foreach ($varsRequiredByView as $varName)
        {
            $currentVar = isset($this->vars[$varName]) ? $this->vars[$varName] : false;

            //don't pass itself
            if ($varName == $viewToFetch)
            {
                continue;
            }
            else if ($currentVar instanceof View)
            {
                $this->fetchChildView($varName, $history);
            }
            else if ($currentVar === false)
            {
                continue;
            }
            $view->set($varName, $currentVar);
        }

        $this->vars[$viewToFetch] = $view->fetch();

        return true;
    }

    /**
     * Opens, parses, and returns the template file.
     */
    public function fetch()
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
 
        foreach (array_keys($this->vars) as $varName)
        {
            //if variable is an instance of View class then replace it with fetch result
            if ($this->vars[$varName] instanceof View)
            {
                $this->fetchChildView($varName);
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

    public function display()
    {
        echo $this->fetch();
    }
}
