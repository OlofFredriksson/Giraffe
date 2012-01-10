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

function get_regions($name = "") {
	global $giraffe;
	if(empty($name)) {
		$regions = array();
		$query = "SELECT * FROM ".DB_PREFIX."region";
		$result = $giraffe->db->query($query);
		while($row = $result->fetch_object()) {
			$regions[$row->name] = $row->content;
		}
	} else {
		$regions = array();
		$query = "SELECT * FROM ".DB_PREFIX."region WHERE name = '".$name."'";
		$result = $giraffe->db->query($query);
		if($result->num_rows == 1) {
			$row = $result->fetch_object();
			$regions = $row->content;
		}
	}
	
	return $regions;
}
?>