<?php
namespace Craft;

class GeoVariable
{
    public function data()
    {
        return craft()->geo_location->getIpData();
    }

    public function isEu()
    {
        return craft()->geo_location->getIsEu();
    }
}