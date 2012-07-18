<?php
class Flickr
{
	// Self-explanitory - change if required
	var $api_url = 'http://api.flickr.com/services/rest/';
	var $api_key = '79b7215500b09ca2c26209eb71ac2ff9';
	var $secret  = '4312614606a4acc0';
	// We'll use serialized php here rather than JSON as this
	// test is limited to PHP/HTML - would be good option for Backbone.js
	var $format  = 'php_serial';
	
	/**
	* Unserialize and pass back flickr response data
	*
	* @param string $response Serialized PHP object
	*
	* @since 1.0
	* @todo Addition of multiple data types (JSON, JSONP etc)
	*/
	public function parseResponse($response)
	{
		return unserialize($response);
	}

	/**
	* Request data from flickr server and parse response
	*
	* @param string $method flickr API method name
	* @param array $params Per-request parameters
	*
	* @since 1.0
	* @todo Handle connection errors
	*/
	public function request($method, $params)
	{
		// Required request parameters
		$required = array(
			'method'  => $method,
			'api_key' => $this->api_key,
			'format'  => $this->format,
		);
		// Merge required params with one-time request params
		$params = array_merge($required, $params);
		// Init cURL and return response
		$curl = curl_init($this->api_url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);
		// Parse returned response
		return $this->parseResponse($response);
	}
	
	/**
	* Search flickr for photos by term
	*
	* @param string $text Search term
	* @param int $page Number of current page
	* @param int $limit Limit of photos per page
	*
	* @since 1.0
	*/
	public function search($text, $page, $limit)
	{
		$params = array(
			'api_key'  => $this->api_key,
			'text'     => $text,
			'page'     => $page,
			'per_page' => $limit
		);
		return $this->request('flickr.photos.search', $params);
	}
	
	/**
	* Retrive info for one photo by ID
	*
	* @param int $photo_id Photo ID from flickr
	*
	* @since 1.0
	*/
	public function getInfo($photo_id)
	{
		$params = array(
			'photo_id' => $photo_id
		);
		return $this->request('flickr.photos.getInfo', $params);
	}
}