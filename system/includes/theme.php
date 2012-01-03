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