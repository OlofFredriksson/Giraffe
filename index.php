<?php
/*
Before you could run this mvc at the first time, make your own config.php
1: Copy system/config-sample.php to system/config.php
2: Change to your database data

ALL SITE SPECIFIC SETTINGS IS DONE IN 'config.php' and in database table 'options'
*/

// ------------------------------ PHASE: SETUP ----------------------------------------------------

define('PATH', dirname(__FILE__));

// Load bootstrapper
require_once(PATH ."/system/core/bootstrap.php");

// Load the core class, Giraffe
$giraffe = Giraffe::instance();


// ------------------------------ PHASE: Frontcontroller ------------------------------------------

$giraffe->front_controller();



// ------------------------------ PHASE: Template engine ------------------------------------------

$giraffe->template_engine();


?>
