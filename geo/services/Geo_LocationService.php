<?php
namespace Craft;

class Geo_LocationService extends BaseApplicationComponent
{

	public function getIpData($ip)
	{
		$response = $this->fetchIpData($ip);

		return $response;
	}

	public function getIsEu($ip)
	{
		$isEu = false;
		$response = $this->fetchIpData($ip);

		if(!empty($response)){
			$isEu = $response['is_eu'];
		}

		return $isEu;
	}
	
	private function fetchIpData($ip)
	{
		$devMode = craft()->config->get('devMode');
		$ipApiKey = craft()->config->get('ipApiKey', 'geo');
		$ip = $ip ? $ip : craft()->request->getIpAddress();
		$locationDataCookie = craft()->config->get('locationDataCookie', 'geo');
		$data = array(
			'country_code'=>'',
			'is_eu'=>''
		);
		
		if($devMode){
			$ip = craft()->config->get('defaultIp', 'geo');
		}

		if(isset($_COOKIE[$locationDataCookie])){
			return json_decode($_COOKIE[$locationDataCookie], true);
		}

		$client = new \Guzzle\Http\Client('https://api.ipstack.com/');
		$url = $ip . '?access_key=' . $ipApiKey . '&fields=location.is_eu,country_code,ip';
		$response = $client->get($url, array(), array('exceptions' => false))->send();
		$data = json_decode($response->getBody());
		
		if (isset($data->error)) {
			GeoPlugin::log($data->error->type.": ".$data->error->info);
			return array();
		}

		if ($data->country_code === null) {
			GeoPlugin::log('Invalid IP Address');
			return array();
		}
		
		$data = array(
			'country_code'=>$data->country_code,
			'is_eu'=>$data->location->is_eu
		);
		
		setcookie($locationDataCookie, json_encode($data));
		
		return $data;
	}
}