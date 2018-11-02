<?php
namespace Craft;

class GeoVariable
{
    public function data($cache=true)
    {
        return craft()->geo_location->getIpData($cache);
    }

    public function isEu($cache=true)
    {
        return craft()->geo_location->getIsEu();
    }
}