<?php
$this->load->view("header");
?>
<h1>Index file in default theme <strong>:D</strong></h1>
<?php
$giraffe = Giraffe::instance();
$giraffe->debug();

dummy_function();
echo $text;
get_footer();
?>