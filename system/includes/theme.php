<?php

function get_header() {
	require_once(PATH."/site/themes/".get_siteInfo("theme")."/header.php");
}

function get_footer() {
	require_once(PATH."/site/themes/".get_siteInfo("theme")."/footer.php");
}