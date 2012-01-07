<?php

function get_header() {
	global $giraffe;
	$giraffe->getController()->load->view("header");
}

function get_footer() {
	global $giraffe;
	$giraffe->getController()->load->view("footer");
}

function get_sidebar() {
	global $giraffe;
	$giraffe->getController()->load->view("sidebar");
}
// Not recommended to use, try to fix the loader instead!
function get_region($region) {
	global $giraffe;
	$giraffe->getController()->load->view($region);
}