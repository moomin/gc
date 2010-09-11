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

    public function getCoordString($type, $format = 'sec')
    {
        if ($type == 'lat')
        {
            $number = abs($this->latitude);
            $compass = $this->latitude ? 'N' : 'S';
        }
        else if ($type == 'lon')
        {
            $number = abs($this->longtitude);
            $compass = $this->longtitude ? 'E' : 'W';
        }
        else
        {
            return false;
        }

        $degreeStr = "\xC2\xB0";

        $degree = (int)floor($number);
        $minutes = fmod($number, 1)*60;
        $seconds = fmod($minutes, 1)*60;

        if ($format == 'sec')
        {
            $str = $compass
                .$degree . $degreeStr
                .(int)floor($minutes) . "'"
                .(int)round($seconds) . "''";
        }
        else if ($format == 'min')
        {
            $str = $compass
                .$degree . $degreeStr
                .round($minutes, 4) . "'";
        }
        else
        {
            $str = $number;
        }

        return $str;
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
