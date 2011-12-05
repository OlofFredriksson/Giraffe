<?php

function get_header() {
	require_once(PATH."/site/themes/".get_siteInfo("theme")."/header.php");
}

function get_footer() {
	require_once(PATH."/site/themes/".get_siteInfo("theme")."/footer.php");
}

function fourofour() {
	header('HTTP/1.0 404 Not Found');
	$file_name = PATH."/site/themes/".get_siteInfo("theme")."/404.php";
	if (file_exists($file_name)) {
			require_once($file_name);
	} else {
		echo "404";
	}
	
}