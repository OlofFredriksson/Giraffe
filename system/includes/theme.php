<?php

function get_header($title = "", $meta_description = "") {
	require_once(SITE_PATH."/themes/".get_siteInfo("theme")."/header.php");
}

function get_footer() {
	require_once(SITE_PATH."/themes/".get_siteInfo("theme")."/footer.php");
}

function get_sidebar() {
	require_once(SITE_PATH."/themes/".get_siteInfo("theme")."/sidebar.php");
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
		echo "404";
	}
	exit;
}