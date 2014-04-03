<?php
	require("CurlWrapper_static.php");

	$cookieSettingUrl = 'http://service.com/';
	$cookie = CurlWrapper::SendRequest($cookieSettingUrl);
	
	$data = array(
		"year" => 2014,
		"day" => 3,
        "month" => 4,
		"id" => 20
    );
	$postData = json_encode($data);
	
	$jsonUrl = 'http://service.com/getData.json';
	$headers = array('Accept: application/json','Content-Type: application/json');
	
	$resultsHTML = CurlWrapper::SendRequest($jsonUrl, $cookieSettingUrl, "POST", $postData, $headers);
	$resultsJson = json_decode($resultsHTML);
	var_dump($resultsJson);	
?>