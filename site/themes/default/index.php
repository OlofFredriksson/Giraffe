﻿<?php
	get_header();
?>
<h1>Index file in default theme <strong>:D</strong></h1>
<?php
$giraffe = Giraffe::instance();
echo "<pre>";
print_r($giraffe->getConfig());
echo "</pre>";

dummy_function();
echo $text;
?>
<?php
	get_footer();
?>