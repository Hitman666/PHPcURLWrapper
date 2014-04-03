PHPcURLWrapper
==============

![alt text](PHPcURL.jpg "PHP biceps cURL")

PHP biceps cURL :)

Following is the PHP cURL wrapper class which I use to make GET and POST requests. The examples are below. Disclamer:  be sure that you have permission to scrape and use the content you're after.

Simple GET request
=================================

```PHP
require("CurlWrapper_static.php");

$googleHTML = CurlWrapper::SendRequest('https://www.google.com');
echo $googleHTML;
```

If you're a firm non-static lover here's a "normal" class simple GET request usage:

```PHP
require("CurlWrapper_nonStatic.php");

$curl = new CurlWrapper();
$googleHTML = $curl->SendRequest('https://www.google.com');
echo $googleHTML;
```

JSON POST request
=================

Here's an example of sending a JSON POST request to imaginitive URL 'http://service.com/getData.json' with some data array:

```PHP
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
```

Important to note is that you have to add proper `$headers` array, and that you `json_encode` your `&data` array as shown when POSTing to a service which expects JSON data.

Cookies
=======

The reason why I first used these two lines:

```PHP
$cookieSettingUrl = 'http://service.com/';
$cookie = CurlWrapper::SendRequest($cookieSettingUrl);
```

is to set any cookies (and you will find that some services do this) that may be needed to be sent along with the request to 'http://service.com/getData.json'. Cookies are set to 'curlCookies.txt' in the CurlWrapper_* class. You can change this to your liking, and you have to make sure that you set proper permissions for this file.

Hope this proves useful to someone.