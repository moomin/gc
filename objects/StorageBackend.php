<?php

abstract class StorageBackend
{
    abstract public function __construct($params);
    abstract protected function escapeData(&$data);
    abstract public function insert($objectName, $objectFields);
    abstract public function update($objectName, $objectFields, $keyFields);
    abstract public function delete($objectName, $keyFields);
    abstract public function find($objectName,
                         $searchFields,
                         $objectFields = false,
                         $orderBy = false,
                         $orderType = false,
                         $limitRows = false,
                         $returnFrom = false);

    public function get($objectName, $searchFields, $objectFields = false)
    {
        if ($rows = $this->find($objectName, $searchFields, $objectFields, false, false, 1))
        {
            return $rows[0];
        }

        return false;
    }

}
