<?php

class GeoCache
{
    const STATUS_NEW = 1;
    const STATUS_VISITED = 2;
    const STATUS_INACTIVE = 3;

    const VOTE_FOUND = 1;
    const VOTE_COMMENT = 2;
    const VOTE_LOST = 3;

    public $id = false;

    public $title = '';

    public $latitude = false;
    public $longtitude = false;

    public $birthTimestamp = false;
    public $submitTimestamp = false;
    public $creator = false;
    public $status = self::STATUS_NEW;

    public $locationDescription = '';
    public $cacheDescription = '';

    public $comments = array();

    public function setCoordinates($latitude, $longtitude)
    {
        if (!preg_match('^[NS]\d{2}\.\d{3}$', $latitude))
        {
            return false;
        }

        if (!preg_match('^[WE]\d{2}\.\d{3}$', $longtitude))
        {
            return false;
        }

        $this->latitude = $latitude;
        $this->longtitude = $longtitude;

        return true;
    }

    public function getCorrdString($type, $format = 'sec')
    {
        if ($type == 'lat')
        {
            $number = $this->latitude;
        }
        else if ($type == 'lon')
        {
            $number = $this->longtitude;
        }
        else
        {
            return false;
        }

        if ($format == 'sec')
        {
            
        }

        return '';
    }

    public function addComment($user, $voteType, $text)
    {
        $comment = array('user' => '',
                         'type' => '',
                         'timestamp' => '',
                         'text' => '');

        $this->comments[] = $comment;

        return true;
    }
}
