<?php
get_header();
?>
<h1><?php echo $h1; ?></h1>
<?php
if(isset($id)) {
	echo "<p>Date: ".$post["date"]."</p>";
	echo $post["content"];
}
else {
	echo "Homepage";
}
get_footer();
?>