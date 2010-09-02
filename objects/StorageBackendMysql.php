<?php

//looks like a bicycle

class StorageBackendMysql extends StorageBackend
{
    protected $db;

    public function __construct($params)
    {
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
                         StorageBackendFieldSet $searchFields,
                         StorageBackendFieldSet $objectFields = null,
                         $orderBy = false,
                         $orderType = false,
                         $limitRows = false,
                         $returnFrom = false)
    {
        $q = 'SELECT ';

        $selectFields = array();

        $fields = $searchFields->getFields();

        while(list($name, $field) = each($fields))
        {
            $selectFields[] = '`'.$name.'`';
        }

        $q .= implode(',', $selectFields);

        $q .= ' FROM `'.$objectName.'`';

        if ($objectFields)
        {
            $q .= ' WHERE';

            if (!get_magic_quotes_gpc())
            {
                $objectFields->applyCallbackToStrings(array($this->db, 'real_escape_string'));
            }

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

                $whereFields[] = '`'.$name.'` = ' . $value;
            }

            $q .= implode (' AND ', $whereFields);
        }

        if ($orderBy)
        {
            $q .= ' ORDER BY `' . $orderBy . '`' . ($orderType ? ' ' . $orderType : '');
        }

        if ($limitRows)
        {
            $q .= ' LIMIT ' .($returnFrom ? $returnFrom . ', ' : ''). $limitRows;
        }

        if ($result = $this->db->query($q))
        {
            $res = array();
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