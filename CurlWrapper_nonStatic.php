<?php
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
}
?>