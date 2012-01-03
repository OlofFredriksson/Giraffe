<?php
get_header();
?>
<h1>404 - File not found</h1>
<?php
$giraffe = Giraffe::instance();
$giraffe->debug();
get_footer();
?>