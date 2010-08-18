<?php

require_once 'StorageBackend.php';
require_once 'StorageBackendMysql.php';

class StorageBackendFactory
{
    static public function getStorageBackend($type, $params)
    {
        switch ($type)
        {
            case 'mysql' :
                return new StorageBackendMysql($params);
                break;
            default:
                return false;
                break;
        }

        return false;
    }

}