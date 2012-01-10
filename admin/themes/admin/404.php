<?php
global $giraffe;
get_header();
?>
<div class="container-fluid">
	<?php if($giraffe->auth->isLoggedIn()) {
		get_sidebar();
	}
	?>
	<div class="content">	
	<div class="row">
		<div class="span16">
			<h2>404</h2>
			<p>File not found</p>
		</div>
	</div>
	<?php get_footer(); ?>