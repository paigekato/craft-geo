<?php
namespace Craft;

class Geo_LocationService extends BaseApplicationComponent
{

	public function getIpData($doCacheData)
	{
		$response = $this->fetchIpData($doCacheData);

		if(!empty($response)){
			return $response;
		}
	}

	public function getIsEu($doCacheData)
	{
		$isEu = false;
		$response = $this->fetchIpData($doCacheData);

		if(!empty($response)){
			$isEu = $response['is_eu'];
		}

		return $isEu;
	}
	
	private function fetchIpData($doCacheData)
	{
		$devMode = craft()->config->get('devMode');
		$ipApiKey = craft()->config->get('ipApiKey', 'geo');
		$ip = craft()->request->getIpAddress();
		$isEuUserCookie = 'craft_geo_eu_user';
		$data = array(
			'ip'=>'',
			'country_code'=>'',
			'is_eu'=>'',
			'cached'=>false
		);
		
		if($devMode){
			$ip = craft()->config->get('defaultIp', 'geo');
		}
		
		$cachedData = craft()->cache->get('craft.geo.' . $ip);

		if ($cachedData){
			$cached = json_decode($cachedData,true);
			$cached['cached'] = true;
			return $cached;
		}

		$client = new \Guzzle\Http\Client('https://api.ipstack.com/');
		$url = $ip . '?access_key=' . $ipApiKey . '&fields=location.is_eu,country_code,ip';
		$response = $client->get($url, array(), array('exceptions' => false))->send();
		$data = json_decode($response->getBody());
		return $data;
		
		if (!$response->getStatusCode()) {
			return array();
		}
		
		$data = array(
			'ip'=>$data->ip,
			'country_code'=>$data->country_code,
			'is_eu'=>$data->location->is_eu,
			'cached'=>true
		);
		
		$isEu = $data['is_eu'] === true ? 'true' : 'false';
		setcookie($isEuUserCookie, $isEu);

		if($doCacheData){
			$cacheTime = craft()->config->get('cacheTime', 'geo');
			craft()->cache->add('craft.geo.' . $ip, json_encode($data), $cacheTime);
		}
		
		return $data;
	}
}