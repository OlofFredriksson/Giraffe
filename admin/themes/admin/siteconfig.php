<?php
get_header();
$url = get_siteInfo("url");
global $giraffe;
?>
<div class="container-fluid">
	<?php get_sidebar(); ?>
	<div class="content">	
	<div class="row">
		<div class="span16">
			<h2>Site configuration</h2>
			<form method="post" action="<?php echo $giraffe->request_handler->site_url("siteconfig"); ?>">
				<div class="clearfix">
					<div class="input-prepend">
						<span class="add-on">Title</span>
						<input class="medium" name="title" value="<?php echo $site_config["title"]; ?>" size="56" type="text"/>
					</div>
				</div>
				<div class="clearfix">
					<span class="add-on">Sub title</span> <br />
					<textarea name="sub_title"><?php echo $site_config["sub_title"]; ?></textarea>
				</div>
				<input class="btn primary" type="submit" name="login" value="Save"/>
			</form>
		</div>
	</div>
	<?php get_footer(); ?>