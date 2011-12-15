<?php
/*
Before you could run this mvc at the first time, make your own config.php
1: Copy system/config-sample.php to system/config.php
2: Change to your database data

ALL SITE SPECIFIC SETTINGS IS DONE IN 'config.php' and in database table 'options'
*/

// ------------------------------ PHASE: SETUP ----------------------------------------------------

define('PATH', dirname(__FILE__));
define('SITE_PATH', PATH."/site");
define('SYSTEM_PATH', dirname(__FILE__)."/system");

// Load bootstrapper
require_once(SYSTEM_PATH ."/core/bootstrap.php");

switch (ENVIRONMENT) {
		case 'development':
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
		break;
		case 'production':
			error_reporting(0);
		break;
		default:
			die("ENVIRONMENT variable not correct");
}

// Load the core class, Giraffe
$giraffe = Giraffe::instance();


// ------------------------------ PHASE: Frontcontroller ------------------------------------------

$giraffe->frontController();



// ------------------------------ PHASE: Template engine ------------------------------------------

$giraffe->templateEngine();


?>
