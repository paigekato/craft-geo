<?php
namespace Craft;

class Geo_LocationService extends BaseApplicationComponent
{

	public function getIpData($doCacheData)
	{
		$ip = craft()->request->getIpAddress();
		$data = [];
		$response = $this->fetchIpData();

		if(!empty($response)){
			// $data = array_merge($data, $response);
			// make array here 
		}

		return $data;
	}

	public function getIsEu()
	{
		$isEu = false;
		$response = $this->fetchIpData();
		
		if(!empty($response)){
			$isEu = $response['is_eu'] === true ? 'true' : 'false';
		}
		
		return $isEu;
	}
	
	private function fetchIpData()
	{
		$devMode = craft()->config->get('devMode');
		$ipApiKey = craft()->config->get('ipApiKey', 'geo');
		$ip = craft()->request->getIpAddress();
		$isEuUserCookie = 'craft_geo_eu_user';
		
		// use EU IP in devMode
		if($devMode){
			$ip = craft()->config->get('defaultIp', 'geo');
		}

		// Check if cookie exists and if so return cached data (array)
		if(isset($_COOKIE[$isEuUserCookie])) {
			// Return cached data
			$cachedData = craft()->cache->get("craft.geo." . $ip);

			if ($cachedData){
				$cached = json_decode($cachedData,true);
				$cached['cached']= true;
				return $cached;
			}
		}

		// If no, fetch from API
		$client = new \Guzzle\Http\Client("https://api.ipstack.com/");
		$url = $ip . "?access_key=" . $ipApiKey . "&fields=location.is_eu,country_code,ip";
		$response = $client->get($url, array(), array("exceptions" => false))->send();
		
		$data = json_decode($response->getBody());
		if (property_exists($data, "type") && $data->type === "error") {
			return array();
		}

		$data = array(
			"ip"=>$data->ip,
			"country_code"=>$data->country_code,
			"is_eu"=>$data->location->is_eu,
			"cached"=>false
		);

		// Save the cookie
		// $isEu = $response['is_eu'] === true ? 'true' : 'false';
		// 	setcookie($isEuUserCookie, $isEu);
		// Save the cached data
		if($doCacheData){
			$cacheTime = craft()->config->get('cacheTime', 'geo');
			craft()->cache->add("craft.geo." . $ip,json_encode($data),$cacheTime);
		}
		
		if (!$response->getStatusCode()) {
			return array();
			// Maybe set a default here
		}
		
		return $data;
	}
}