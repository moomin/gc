<?php

//looks like a bicycle

/**
 *
 *
 * @todo add condition field (to use in WHERE section)
 */
class StorageBackendFieldSet
{
    protected $fields;

    public function __construct($fields = false, $source = false)
    {
        if (!$fields)
        {
            return true;
        }

        $this->fields = array();

        foreach ($fields as $name => $type)
        {
            $value = false;

            if (is_object($source) && isset($source->$name))
            {
                $value = $source->$name;
            }
            else if (is_array($source) && isset($source[$name]))
            {
                $value = $source[$name];
            }
            else if ($source === false)
            {
                $value = '';
            }

            if (is_bool($value))
            {
                continue;
            }

            $this->fields[$name] = array('type' => $type,
                                         'value' => $value);
        }
    }
    
    public function applyCallbackToStrings($callback)
    {
        if (!is_callable($callback))
        {
            return false;
        }

        foreach ($this->fields as &$field)
        {
            if (in_array($field['type'], array('string', 'WKT')))
            {
                $field['value'] = call_user_func($callback, $field['value']);
            }
        }

        return true;
    }

    public function setField($name, $type, $value = false, $condition = false)
    {
        $this->fields[$name] = array('type' => $type,
                                     'condition' => $condition,
                                     'value' => $value);

        return true;
    }

    public function getFieldValue($name)
    {
        return isset($this->fields[$name]) ? $this->fields[$name]['value'] : false;
    }

    public function getFieldCondition($name)
    {
        return isset($this->fields[$name]) ? $this->fields[$name]['condition'] : false;
    }

    public function getFields()
    {
        return $this->fields;
    }
}

abstract class StorageBackend
{
    abstract public function __construct($params);
    abstract public function insert($objectName, StorageBackendFieldSet $objectFields);
    abstract public function update($objectName, StorageBackendFieldSet $objectFields, StorageBackendFieldSet $keyFields);
    abstract public function delete($objectName, StorageBackendFieldSet $keyFields);
    abstract public function find($objectName,
                                  StorageBackendFieldSet $conditionFields = null,
                                  StorageBackendFieldSet $getFields = null,
                                  $orderBy = false,
                                  $orderType = false,
                                  $limitRows = false,
                                  $returnFrom = false);

    public function get($objectName,
                        StorageBackendFieldSet $conditionFields,
                        StorageBackendFieldSet $getFields = null)
    {
        if ($rows = $this->find($objectName, $conditionFields, $getFields, false, false, 1))
        {
            return $rows[0];
        }

        return false;
    }

}
