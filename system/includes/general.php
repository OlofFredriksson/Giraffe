<?php
function get_siteInfo($value = "") {
	global $giraffe;
	$config = $giraffe->getConfig();
	$output = "";
	switch ($value) {
		case "theme":
			$output = $config["theme"];
		break;
		
		case "prefix":
			$output = $config["uri_prefix"];
		break;
	}
	
	return $output;
}
?>