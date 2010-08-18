<?php

require_once 'SiteController.php';
require_once 'CacheView.php';
require_once 'CacheListView.php';
require_once 'GeoCache.php';

class CacheController extends SiteController
{
    public function defaultAction()
    {
        $this->list();
    }
    
    public function add()
    {
        $cacheView = new CacheView;
        $cacheView->set(Site::getInstance());
        $cacheView->set(new GeoCache);
        $cacheView->edit = true;

        $this->addView($cacheView);

        return $this->displayAll();
    }

    public function submit()
    {
        $cache = new GeoCache;
        $this->fillObject($cache,
                          array('id',
                                'title',
                                'latitude',
                                'longtitude',
                                'locationDescription',
                                'cacheDescription'));
                                        
        Site::getInstance()->storage->saveCache($cache);

        return false;
    }

    public function show()
    {
        $cacheView = new CacheView;
        $cacheView->set(Site::getInstance());
        $cacheView->set(new GeoCache());

        $this->addView($cacheView);

        return $this->displayAll();
    }

    public function showList()
    {
        $cacheList = new CacheListView;
        $cacheList->set(Site::getInstance());
        $cacheList->caches = array();
        $this->addView($cacheList);
        
        return $this->displayAll();
    }

}
