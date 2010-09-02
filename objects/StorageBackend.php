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

    public function __construct($source, $fields)
    {
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
            else if ($source == false)
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

    public function setField($name, $type, $value)
    {
        $this->fields[$name] = array('type' => $type,
                                      'value' => $value);

        return true;
    }

    public function getField($name)
    {
        return isset($this->fields[$name]) ? $this->fields[$name]['value'] : false;
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
                         StorageBackendFieldSet $searchFields,
                         StorageBackendFieldSet $objectFields = null,
                         $orderBy = false,
                         $orderType = false,
                         $limitRows = false,
                         $returnFrom = false);

    public function get($objectName, StorageBackendFieldSet $searchFields, StorageBackendFieldSet $objectFields = null)
    {
        if ($rows = $this->find($objectName, $searchFields, $objectFields, false, false, 1))
        {
            return $rows[0];
        }

        return false;
    }

}
