<?php
function get_siteInfo($value = "") {
	global $giraffe;
	$config = $giraffe->getConfig();
	$output = "";
	switch ($value) {
		case "default_controller":
		case "default_controller_clean_urls":
		case "theme":
		case "uri_prefix":
		case "title":
		case "url":
		case "sub_title":
			$output = $config[$value];
		break;
		case "stylesheet_url":
			$path = substr(SITE_PATH, strlen(PATH));
			$output = $config["url"].$path."/themes/".$config["theme"]."/style.css";
		break;
		
		case "theme_url":
			$path = substr(SITE_PATH, strlen(PATH));
			$output = $config["url"].$path."/themes/".$config["theme"];
		break;
	}	
	return $output;
}

function the_siteInfo($value) {
	echo get_siteInfo($value);
}

function starts_with($haystack, $needle) {
	$needle_length = strlen($needle);
	return ($needle_length <= strlen($haystack)) && (substr($haystack, 0, $needle_length) === $needle);
}

function ends_with($haystack, $needle) {
	$length = strlen($needle);
	$start  = $length * -1; //negative
	return (substr($haystack, $start) === $needle);
}

function base_url() {  
	$url = "";
	$serverPort = ($_SERVER["SERVER_PORT"] == "80") ? '' :
		(($_SERVER["SERVER_PORT"] == 443 && @$_SERVER["HTTPS"] == "on") ? '' : ":{$_SERVER['SERVER_PORT']}");
	$url = 'http' . ((@$_SERVER["HTTPS"] == "on") ? 's' : '') . '://';
	$url .= $_SERVER["SERVER_NAME"] . $serverPort . htmlspecialchars(dirname($_SERVER['SCRIPT_NAME']));

	return $url;
  }

?>