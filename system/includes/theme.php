<?php

function get_header() {
	global $giraffe;
	$giraffe->getController()->loadView("header");
}

function get_footer() {
	global $giraffe;
	$giraffe->getController()->loadView("footer");
}

function get_sidebar() {
	global $giraffe;
	$giraffe->getController()->loadView("sidebar");
}

function fourofour($developer_msg = "") {
	header('HTTP/1.0 404 Not Found');
	if(ENVIRONMENT == "development") {
		echo $developer_msg;
	}
	$file_name = SITE_PATH."/themes/".get_siteInfo("theme")."/404.php";
	if (file_exists($file_name)) {
			require_once($file_name);
	} else {
		echo "404 - File not found";
	}
	exit;
}