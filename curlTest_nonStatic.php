<?php
	require("CurlWrapper_nonStatic.php");

	$curl = new CurlWrapper();
	$googleHTML = $curl->SendRequest('https://www.google.com');
	echo $googleHTML;
?>