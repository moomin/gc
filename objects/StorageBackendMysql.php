<?php

class StorageBackendMysql implements StorageBackend
{
    public function init($parameters)
    {
        

    }
 
    public function add($objectName, $objectFields);
    public function get($objectName, $objectFields = false);
    public function update($objectName, $objectFields, $keyFields);
    public function delete($objectName, $keyFields);
    public function find($objectName, $searchFields, $objectFields);

}