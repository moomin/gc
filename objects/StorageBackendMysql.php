<?php

//looks like a bicycle

class StorageBackendMysql extends StorageBackend
{
    protected $db;

    public function __construct($params)
    {
        if (!class_exists('MySQLi', false))
        {
            throw new Exception('class MySQLi is not defined');
        }

        $db = new MySQLi($params['host'],
                         $params['user'],
                         $params['pass'],
                         $params['db']);

        if ($db)
        {
            $db->real_query("SET NAMES 'utf8'");

            $this->db = $db;
            return true;
        }

    }
 
    public function getError()
    {
        return $this->db->error;
    }

    public function insert($objectName, StorageBackendFieldSet $objectFields)
    {
        if (!get_magic_quotes_gpc())
        {
            $objectFields->applyCallbackToStrings(array($this->db, 'real_escape_string'));
        }

        $q = 'INSERT INTO `'.$this->db->real_escape_string($objectName).'` SET';

        $nameValuePairs = array();

        $fields = $objectFields->getFields();

        while(list($name, $field) = each($fields))
        {
            //values which don't need quotes around it
            if (in_array($field['type'], array('int', 'float')))
            {
                $value = $field['value'];
            }
            //values which require quoutes around
            else if ($field['type'] == 'string')
            {
                $value = "'".$field['value']."'";
            }
            else if ($field['type'] == 'WKT')
            {
                $value = "GeomFromText('".$field['value']."')";
            }
            else
            {
                continue;
            }

            $nameValuePairs[] = "`".$name."`=".$value;
        }

        $q .= implode(',', $nameValuePairs);

        return $this->db->real_query($q);
    }

    public function update($objectName, StorageBackendFieldSet $objectFields, StorageBackendFieldSet $keyFields)
    {
        return true;
    }

    public function delete($objectName, StorageBackendFieldSet $keyFields)
    {
        return true;
    }

    public function find($objectName,
                         StorageBackendFieldSet $conditionFields = null,
                         StorageBackendFieldSet $getFields = null,
                         $orderBy = false,
                         $orderType = false,
                         $limitRows = false,
                         $returnFrom = false)
    {
        $q = 'SELECT ';

        //SELECT ...
        if ($getFields)
        {
            $selectFields = array();

            $fields = $getFields->getFields();

            while(list($name, $field) = each($fields))
            {
                $selectFields[] = '`'.$name.'`';
            }

            $q .= implode(',', $selectFields);
        }
        else
        {
            $q .= '*';
        }

        $q .= ' FROM `'.$objectName.'`';

        //WHERE ...
        if ($conditionFields)
        {
            $q .= ' WHERE';

            if (!get_magic_quotes_gpc())
            {
                $conditionFields->applyCallbackToStrings(array($this->db, 'real_escape_string'));
            }

            $fields = $conditionFields->getFields();

            while(list($name, $field) = each($fields))
            {
                //values which don't need quotes around it
                if (in_array($field['type'], array('int', 'float')))
                {
                    $value = $field['value'];
                }
                //values which require quoutes around
                else if ($field['type'] == 'string')
                {
                    $value = "'".$field['value']."'";
                }

                switch ($field['condition'])
                {
                    case '=':
                    case 'eq':
                        $conditionString = '=';
                    break;
                    default:
                        $conditionString = '=';
                }

                $whereFields[] = '`'.$name.'` ' .$conditionString. ' ' . $value;
            }

            $q .= implode (' AND ', $whereFields);
        }

        //ORDER BY ...
        if ($orderBy)
        {
            $q .= ' ORDER BY `' . $orderBy . '`' . ($orderType ? ' ' . $orderType : '');
        }

        //LIMIT ...
        if ($limitRows)
        {
            $q .= ' LIMIT ' .($returnFrom ? $returnFrom . ', ' : ''). $limitRows;
        }

        //perform query
        if ($result = $this->db->query($q))
        {
            $res = array();
 
            //fetch all rows
            while($row = $result->fetch_assoc())
            {
                $res[] = $row;
            }

            return $res;
        }
        else
        {
            return false;
        }
    }

}
