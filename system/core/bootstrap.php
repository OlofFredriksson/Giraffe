<?php
// If config.php dont exist, take user to the installer setup 
if(!file_exists(SYSTEM_PATH."/config.php")) {
	header("Location: setup/");
	exit;
}
// Site specific setup
require_once(SYSTEM_PATH."/config.php");

//Core files
require_once(SYSTEM_PATH."/core/load.php");
require_once(SYSTEM_PATH."/core/controller.php");
require_once(SYSTEM_PATH."/core/model.php");
require_once(SYSTEM_PATH."/core/request-handler.php");
require_once(SYSTEM_PATH."/core/database.php");
require_once(SYSTEM_PATH."/core/auth.php");
require_once(SYSTEM_PATH."/core/giraffe.php");

// Function files
require_once(SYSTEM_PATH."/includes/general.php");
require_once(SYSTEM_PATH."/includes/theme.php");
?>