<?php
get_header();
?>
<h1>CMS page controller</h1>
<?php
if(isset($id)) {
	echo "Post with id: ".$id."<br />";
	echo $modeltest;
}
else {
	echo "Homepage";
}
get_footer();
?>