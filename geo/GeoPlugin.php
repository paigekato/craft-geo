<?php
namespace Craft;

class GeoPlugin extends BasePlugin
{
    public function getName()
    {
         return Craft::t('IP Stack');
    }

    public function getDescription()
    {
         return 'A tweaked version of geo cache by Luke Holder, to use a new IP API, IP Stack:https://ipstack.com';
    }

    public function getVersion()
    {
        return '1.4';
    }

    public function getDeveloper()
    {
        return 'Paige Kato';
    }

    public function getDeveloperUrl()
    {
        return 'https://github.com/paigekato/craft-geo';
    }
}
