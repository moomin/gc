<?php

/**
 * A set of validators for different data
 * 
 * @author Serhii Piddubchak
 */

/**
 * Interface for different validators
 */
interface Validator
{
    /**
     * Validate data
     * 
     * @param mixed $value
     * @return bool - true if value is valid; false if not
     */
    public function isValid($value);

    /**
     * Get valid values
     *
     * @return mixed false if no specific values are considered as valid;
     *               string for textual representation of valid values;
     *               array for list of valid values;
     */
    public function getValidValues();
}

/**
 * Boolean validator
 *
 * Validates boolean data
 */
class ValidatorBool implements Validator
{
    public function isValid($value)
    {
        return in_array((string)$value, array('', //bool false juggles to this string
                                              '0', //bool true juggles to this string
                                              '1', //bool true juggles to this string
                                              'false', //string false in cfg file
                                              'true', //string true in cfg file
                                              ));
    }

    public function getValidValues()
    {
        return false;
    }
}


/**
 * Integer Validator
 *
 * Validates integer data
 */
class ValidatorInt implements Validator
{
    public function isValid($value)
    {
        return (string)(int)$value === (string)$value;
    }

    public function getValidValues()
    {
        return false;
    }
}

/**
 * Enum Validator
 *
 * Validates data as a member of some predefined set
 */
class ValidatorEnum implements Validator
{
    /**
     * Holds an array of valid values
     * @var array
     */
    protected $enumList;

    /**
     * Constructor
     *
     * @param array $enumList array of valid values
     */
    public function __construct($enumList)
    {
        if (is_array($enumList))
        {
            $this->enumList = $enumList;
        }
        else
        {
            $this->enumList = array();
        }
    }

    /**
     * Validate data
     *
     * @param mixed $value 
     * @return bool true if value is one of valid values; false otherwise
     */
    public function isValid($value)
    {
        return in_array($value, $this->enumList);
    }

    /**
     * Get list of valid values
     *
     * @return array valid values
     */
    public function getValidValues()
    {
        return $this->enumList;
    }
}

/**
 * Regexp Validator
 *
 * Validates data by regular expression
 */
class ValidatorRegexp implements Validator
{
    /**
     * Holds regular expression
     * @var string
     */
    protected $regexp;

    /**
     * Constructor
     *
     * @param string Perl Compatible Regular Expression
     */
    public function __construct($regexp)
    {
        $this->regexp = $regexp;
    }

    /**
     * Validate data
     *
     * @param string $value
     * @return bool true if value matches regexp; false otherwise
     */
    public function isValid($value)
    {
        return preg_match($this->regexp, $value);
    }

    /**
     * Get regular expression
     *
     * @return string $regexp class member
     */
    public function getValidValues()
    {
        return $this->regexp;
    }
}
