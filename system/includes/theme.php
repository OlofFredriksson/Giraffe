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

function get_file($file) {
	global $giraffe;
	$giraffe->getController()->load->view($region);
}