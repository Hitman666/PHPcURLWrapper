PHPcURLWrapper
==============

![alt text](PHPcURL.jpg "PHP biceps cURL")

PHP biceps cURL :)

Following is the PHP cURL wrapper class which I use to make GET and POST requests. The examples are below. Disclamer:  be sure that you have permission to scrape and use the content you're after.

This code is also available on GitHub at this link: https://github.com/Hitman666/PHPcURLWrapper

Class code and simple GET request
=================================

`//CurlWrapper_static.php

class CurlWrapper {
    private static $useragents = array(            
        "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36",
        "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; WOW64; Trident/4.0; SLCC1)",
        "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/537.75.14"
    );

	private static $cookiesFile = "curlCookies.txt";

    private static function getUserAgent() {
    	$rand = rand(0, count(self::$useragents) - 1);

    	return self::$useragents[$rand];
    }

    public static function SendRequest($url, $ref = "", $type = "GET", $postData = "", $headers = "", $proxy = "") {
        $useragent = self::getUserAgent();

        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_TIMEOUT,120);
		curl_setopt($ch, CURLOPT_USERAGENT, self::getUserAgent());

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);

		curl_setopt($ch, CURLOPT_COOKIEJAR, realpath(self::$cookiesFile)); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, realpath(self::$cookiesFile));

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //options
        if ($ref != "") {
            curl_setopt($ch, CURLOPT_REFERER, $ref);
        }

		if ($proxy != "") {
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
		}

		if ($type == "POST"){
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		}

		if ($headers != ""){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

        $result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}
}`

Simple GET request:

`require("CurlWrapper_static.php");

$googleHTML = CurlWrapper::SendRequest('https://www.google.com');
echo $googleHTML;`

If you're a firm non-static lover here's a "normal" class:

`//CurlWrapper_nonStatic.php

class CurlWrapper{    
    private $_useragents = array(            
        "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36",
        "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; WOW64; Trident/4.0; SLCC1)",
        "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/537.75.14"
    );

	private $_cookiesFile = "curlCookies.txt";

    private function getUserAgent(){
    	$rand = rand(0, count($this->_useragents));

    	return $useragents[$rand];
    }

    public function SendRequest($url, $ref = "", $type = "GET", $postData = "", $headers = "", $proxy = "") {
        $useragent = $this->getUserAgent();
        echo $useragent;

        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_TIMEOUT,120);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);

		curl_setopt($ch, CURLOPT_COOKIEJAR, realpath($this->_cookiesFile)); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, realpath($this->_cookiesFile));

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //options
        if ($ref != "") {
            curl_setopt($ch, CURLOPT_REFERER, $ref);
        }

		if ($proxy != "") {
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
		}

		if ($type == "POST"){
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		}

		if ($headers != ""){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

        $result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}
}`

How to use it with simple GET request:

`require("CurlWrapper_nonStatic.php");

$curl = new CurlWrapper();
$googleHTML = $curl->SendRequest('https://www.google.com');
echo $googleHTML;`

JSON POST request
=================

Here's an example of sending a JSON POST request to imaginitive URL 'http://service.com/getData.json' with some data array:

`	require("CurlWrapper_static.php");

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
	var_dump($resultsJson);`

Important to note is that you have to add proper $headers array, and that you json_encode your data array as shown when POSTing to a service which expects JSON data.

Cookies
=======

The reason why I first used these two lines:

`$cookieSettingUrl = 'http://service.com/';
$cookie = CurlWrapper::SendRequest($cookieSettingUrl);`

is to set any cookies (and you will find that some services do this) that may be needed to be sent along with the request to 'http://service.com/getData.json'. Cookies are set to 'curlCookies.txt' in the CurlWrapper_* class. You can change this to your liking, and you have to make sure that you set proper permissions for this file.

Hope this proves useful to someone.