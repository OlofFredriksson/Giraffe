<?php
// If config.php dont exist, take user to the installer setup 
if(!file_exists(SYSTEM_PATH."/config.php")) {
	header("Location: setup/");
	exit;
}
// Site specific setup
require_once(SYSTEM_PATH."/config.php");

//Load our base Controller
require_once("controller.php");

//Load our base Controller
require_once("request-handler.php");

// The core class
require_once("giraffe.php");

// Function files
require_once(SYSTEM_PATH."/includes/general.php");
require_once(SYSTEM_PATH."/includes/theme.php");
// Reserved controller names
$reserved = array('Controller');

?>