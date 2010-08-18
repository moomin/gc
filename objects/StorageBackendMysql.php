<?php

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
 
    protected function escapeData(&$data)
    {
        foreach ($data as $name => &$value)
        {
            $value = $this->db->real_escape_string($value);
        }

        return true;
    }

    public function insert($objectName, $objectFields)
    {
        $this->escapeData($objectFields);

        $q = 'INSERT INTO `'.$this->db->real_escape_string($objectName).'` ';

        foreach ($objectFields as $name => $value)
        {
            $q .= " SET `".$name."`='".$value."'" . current($objectFields) !== false . ', ';
        }

        var_dump($q);
        return $this->storage->real_query($q);
    }

    public function update($objectName, $objectFields, $keyFields)
    {
        return true;
    }

    public function delete($objectName, $keyFields)
    {
        return true;
    }

    public function find($objectName,
                         $searchFields,
                         $objectFields = false,
                         $orderBy = false,
                         $orderType = false,
                         $limitRows = false,
                         $returnFrom = false)
    {

    }

}