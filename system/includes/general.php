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
		
		case "title":
			$output = $config["title"];
		break;
		
		case "url":
			$output = $config["url"];
		break;
		
		case "sub_title":
			$output = $config["sub_title"];
		break;
		
		case "stylesheet_url":
			$output = $config["url"]."/site/themes/".$config["theme"]."/style.css";
		break;
		
		case "theme_url":
			$output = $config["url"]."/site/themes/".$config["theme"];
		break;
		
		case "default_controller":
			$output = $config["default_controller"];
		break;
		
		case "default_controller_clean_urls":
			$output = $config["default_controller_clean_urls"];
		break;

	}
	
	return $output;
}

function the_siteInfo($value) {
	echo get_siteInfo($value);
}
?>