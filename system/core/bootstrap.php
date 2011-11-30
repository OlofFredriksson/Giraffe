<?php
// If config.php dont exist, take user to the installer setup 
if(!file_exists("system/config.php")) {
	header("Location: setup/");
	exit;
}
// Site specific setup
require_once("system/config.php");

//Load our base API
require_once("application.php");

//Load our base Controller
require_once("controller.php");

// The core class
require_once("giraffe.php");


define("THEME","default");
?>