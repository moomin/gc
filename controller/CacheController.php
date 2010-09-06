<?php

require_once 'SiteController.php';
require_once 'CacheView.php';
require_once 'CacheListView.php';
require_once 'GeoCache.php';

class CacheController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function defaultAction()
    {
        $this->showList();
    }
    
    public function add()
    {
        $cacheView = new CacheView;
        $cacheView->set($this->site);
        $cacheView->set('html', $this->site->html);
        $cacheView->set('txt', $this->site->text);
        $cacheView->set(new GeoCache);
        $cacheView->edit = true;

        $this->addView($cacheView);

        return $this->displayAll();
    }

    public function submit()
    {
        $site = Site::getInstance();

        $cache = new GeoCache;
        $this->updateObject($cache,
                          array('id',
                                'title',
                                'locationDescription',
                                'cacheDescription'));
                                        
        $cache->creator = $site->user->name;

        if (!$decimalMinutes = $this->getDecimalMinutes($this->post['latitudeMinutes']))
        {
            return false;
        }

        $decimalDegree = (float)$this->post['latitudeDegree'] + $decimalMinutes;
        $cache->latitude = (float)($this->post['latitudeSign'].$decimalDegree);

        if (!$decimalMinutes = $this->getDecimalMinutes($this->post['longtitudeMinutes']))
        {
            return false;
        }

        $decimalDegree = (float)$this->post['longtitudeDegree'] + $decimalMinutes;
        $cache->longtitude = (float)($this->post['longtitudeSign'].$decimalDegree);

        if ($cache->id)
        {
            $existingCache = $site->storage->getCache($cache->id);
        }
        else
        {
            $existingCache = false;
        }

        //if cache exists but cannot be updated
        if ($existingCache &&
            (
             ($existingCache->creator != $cache->creator) ||
             ($existingCache->submitTimestamp+(60*60*24*3) < gmmktime())
            )
           )
        {
            return false;
        }
        else if ($existingCache)
        {
            //force title from existing cache
            $cache->title = $existingCache->title;
        }

        $site->storage->saveCache($cache);

        //prepare redirect page
        $redirectView = new View('RedirectView.tpl');
        $redirectView->set('message', 'cache has been successufully saved');
        $redirectView->set('seconds', 10);
        $redirectView->set('targetName', 'main page');
        $redirectView->set('targetUrl', $site->getUrl('cache', 'showList'));
        $redirectView->set('txt', $site->text);

        $this->addView($redirectView);
        $this->displayAll();

        return true;
    }

    protected function getDecimalMinutes($string)
    {
        $minutesRegexp = "/^(\d{2})(\.|\')(\d{2,4})$/";

        if (!preg_match($minutesRegexp, $string, $minutes))
        {
            return false;
        }

        if ($minutes[2] == '.')
        {
            $decimalMinutes = (float)($minutes[1].'.'.$minutes[3]);
            $decimalMinutes = $decimalMinutes / 60;
        }
        else if ($minutes[2] == "'")
        {
            $decimalMinutes = (float)($minutes[1] + (float)($minutes[3] / 60));
        }

        return $decimalMinutes;
    }

    public function view()
    {
        $id = $this->get['id'];

        $cacheView = new CacheView;
        $cacheView->set($this->site);
        $cacheView->set('edit', false);
        $cacheView->set('html', $this->site->html);
        $cacheView->set($this->site->storage->getCache($id));

        $this->addView($cacheView);

        return $this->displayAll();
    }

    public function showList()
    {
        $cacheList = new CacheListView;
        $cacheList->set($this->site);

        $caches = $this->site->storage->getCaches();

        $cacheList->caches = $caches;
        $this->addView($cacheList);
        
        return $this->displayAll();
    }

}
