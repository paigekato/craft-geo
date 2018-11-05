<?php
namespace Craft;

class Geo_LocationService extends BaseApplicationComponent
{

	public function getIpData()
	{
		$response = $this->fetchIpData();

		if(!empty($response)){
			return $response;
		}
	}

	public function getIsEu()
	{
		$isEu = false;
		$response = $this->fetchIpData();

		if(!empty($response)){
			$isEu = $response['is_eu'];
		}

		return $isEu;
	}
	
	private function fetchIpData()
	{
		$devMode = craft()->config->get('devMode');
		$ipApiKey = craft()->config->get('ipApiKey', 'geo');
		$ip = craft()->request->getIpAddress();
		$isEuUserCookie = 'craft_geo_eu_user';
		$data = array(
			'ip'=>'',
			'country_code'=>'',
			'is_eu'=>''
		);
		
		if($devMode){
			$ip = craft()->config->get('defaultIp', 'geo');
		}

		if(isset($_COOKIE[$isEuUserCookie])){
			return json_decode($_COOKIE[$isEuUserCookie], true);
		}

		$client = new \Guzzle\Http\Client('https://api.ipstack.com/');
		$url = $ip . '?access_key=' . $ipApiKey . '&fields=location.is_eu,country_code,ip';
		$response = $client->get($url, array(), array('exceptions' => false))->send();
		$data = json_decode($response->getBody());
		
		if (!$response->getStatusCode()) {
			return array();
		}
		
		$data = array(
			'ip'=>$data->ip,
			'country_code'=>$data->country_code,
			'is_eu'=>$data->location->is_eu
		);
		
		setcookie($isEuUserCookie, json_encode($data));
		
		return $data;
	}
}