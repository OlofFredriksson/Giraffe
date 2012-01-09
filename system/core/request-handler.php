<?php
class RequestHandler {

	public function __construct() {
	
	}
	
	public function forwardTo($url, $status_code = 302){
	
		switch($status_code) {
			case 301:
				header ('HTTP/1.1 301 Moved Permanently');
			break;
			
			case 404:
				header('HTTP/1.0 404 Not Found');
			break;
			
			default:
			
			break;
		}
		if(!preg_match("/^https?:\/\//i",$url)) {
			$url = get_siteInfo("url")."/".$url;
		}
			header('Location:'.$url);
			exit();
	}
	public function getCurrentUrl() {
		$url = 'http';
		if ($_SERVER["HTTPS"] == "on") { 
			$url .= "s";
		}
		$url .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
		$url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
		$url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}

		return $url;
	}
}
?>