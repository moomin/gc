<?php

require_once 'GeoCache.php';

class Storage
{
    protected $backend;

    public function __construct(StorageBackend $backend)
    {
        $this->backend = $backend;
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
        $data = array();

        $fields = array('id',
                        'title',
                        'birthTimestamp',
                        'submitTimestamp',
                        'creator',
                        'status',
                        'cacheDescription',
                        'locationDescription');

        $data = array_merge($data, $this->getObjectFields($cache, $fields));

        $data['point'] = 'POINT('.$cache->latitude.', '.$cache->longtitude.')';

        $id = $data['id'];
        unset($data['id']);

        if (!$id)
        {
            return $this->backend->insert('geocache', $data);
        }
        else
        {
            return $this->backend->update('geocache', $data, array('id' => $id));
        }
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

}