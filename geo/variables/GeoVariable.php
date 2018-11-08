<?php
namespace Craft;

class GeoVariable
  {
  public function data($ip='')
  {
    return craft()->geo_location->getIpData($ip);
  }

  public function isEu($ip='')
  {
    return craft()->geo_location->getIsEu($ip);
  }
}