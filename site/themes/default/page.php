<?php
global $giraffe;
$this->load->view("header");
?>
<h1><?php echo $h1; ?></h1>
	<ul class="breadcrumb">
		<?php list_navbar("default","top"); ?>
	</ul>

<div class="row">
	<div class="span10">
		<?php
		if(isset($id)) {
			echo "<p>Date: ".$post["date"]."</p>";
			echo $post["content"];
		}
		else {
			echo "Home page";
		}
		?>
	</div>
	<?php
	get_sidebar();
	get_footer();
	?> 