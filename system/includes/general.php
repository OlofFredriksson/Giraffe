<?php
function get_siteInfo($value = "") {
	global $giraffe;
	$config = $giraffe->getConfig();
	$output = "";
	switch ($value) {
		case "theme":
			$output = $config["theme"];
		break;
		
		case "uri_prefix":
			$output = $config["uri_prefix"];
		break;
		
		case "stylesheet_url":
			$output = $config["url"]."/site/themes/".$config["theme"]."/style.css";
		break;
		
		case "default_controller":
			$output = $config["default_controller"];
		break;
	}
	
	return $output;
}

function the_siteInfo($value) {
	echo get_siteInfo($value);
}
?>