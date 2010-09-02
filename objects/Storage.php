<?php

require_once 'GeoCache.php';
require_once 'StorageBackend.php';

class Storage
{
    protected $backend;

    public function __construct(StorageBackend $backend)
    {
        $this->backend = $backend;
    }

    public function getError()
    {
        return $this->backend->getError();
    }

    public function getObjectFields($object, $fields)
    {
        $data = array();

        foreach ($fields as $fieldName)
        {
            $data[$fieldName] = $object->$fieldName;
        }

        return $data;
    }

    // geocache related methods

    public function saveCache(GeoCache $cache)
    {
        $data = array('id' => 'int',
                        'title' => 'string',
                        'birthTimestamp' => 'int',
                        'submitTimestamp' => 'int',
                        'creator' => 'string',
                        'status' => 'int',
                        'cacheDescription' => 'string',
                        'locationDescription' => 'string');

        //        $fields = array_merge($data, $this->getObjectFields($cache, $data));
        $fields = new StorageBackendFieldSet($cache, $data);

        $fields->setField('point', 'WKT', 'POINT('.$cache->latitude.' '.$cache->longtitude.')');

        if (!$fields->getField('id'))
        {
            $result = $this->backend->insert('geocache', $fields);
        }
        else
        {
            $keyFields = new StorageBackendFieldSet($cache, array('id' => 'int'));
            $result = $this->backend->update('geocache', $data, $keyFields);
        }

        if (!$result)
        {
            throw new Exception($this->getError());
        }

        return $result;
    }

    public function getCache($id)
    {
        if ($data = $this->backend->get('geocache', array('id' => $id)))
        {
            $cache = new GeoCache;
            return $cache;
        }
        
        return false;
    }

    public function getCaches(StorageBackendFieldSet $conditions = null, $limit = 10, $startFrom = false)
    {
        $data = array('id' => 'int',
                        'title' => 'string',
                        'birthTimestamp' => 'int',
                        'submitTimestamp' => 'int',
                        'creator' => 'string',
                        'status' => 'int',
                        'cacheDescription' => 'string',
                        'locationDescription' => 'string');

        $fieldsToReturn = new StorageBackendFieldSet(new GeoCache,
                                                     $data);

        return $this->backend->find('geocache', $fieldsToReturn, null, 'submitTimestamp', 'DESC', $limit, $startFrom);
    }

}