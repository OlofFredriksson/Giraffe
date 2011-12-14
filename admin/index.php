<?php
// ------------------------------ PHASE: SETUP ----------------------------------------------------
define('PATH', dirname(__FILE__));
define('SYSTEM_PATH', dirname(__FILE__)."/../system");
define('SITE_PATH', PATH);

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

# TBD, override data from database
$config = array(
	'theme'  => 'admin',
	'default_controller' => 'dashboard',
	'default_controller_clean_urls' => '',
	'url' => 'http://mvc.snafu.me/admin',
);

// Load the core class, Giraffe
$giraffe = Giraffe::instance($config);


// ------------------------------ PHASE: Frontcontroller ------------------------------------------

$giraffe->frontController("admin/");



// ------------------------------ PHASE: Template engine ------------------------------------------

$giraffe->templateEngine();


?>
