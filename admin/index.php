<?php
// ------------------------------ PHASE: SETUP ----------------------------------------------------
define('PATH', dirname(__FILE__));
define('SYSTEM_PATH', PATH."/../system");
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

// Load the core class, Giraffe
$giraffe = Giraffe::instance("admin");


// ------------------------------ PHASE: Frontcontroller ------------------------------------------

$giraffe->frontController();



// ------------------------------ PHASE: Template engine ------------------------------------------

$giraffe->templateEngine();


?>
