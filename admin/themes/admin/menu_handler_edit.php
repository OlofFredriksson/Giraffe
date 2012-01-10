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
			<h2>Edit link - Menu handler</h2>
			<br style="clear:both;" />
			<form method="post" action="<?php echo $giraffe->request_handler->site_url("menuhandler/edit"); ?>" class="form-stacked">
			<input name="id" type="hidden" value="<?php echo $link["id"];?>"/>
			<div class="clearfix">
			<label for="xlInput3">Site</label>
			<div class="input">
				<input class="xlarge" name="site" size="30" value="<?php echo $link["site"];?>" type="text" />
			</div>
			</div><!-- /clearfix -->
			
			<div class="clearfix">
				<label for="xlInput">Title</label>
				<div class="input">
					<input class="xlarge" name="title" value="<?php echo $link["title"];?>" size="30" type="text" />
				</div>
			</div><!-- /clearfix -->
			
			<div class="clearfix">
				<label for="xlInput">Url</label>
				<div class="input">
					<input class="xlarge" name="url" value="<?php echo $link["url"];?>" size="30" type="text" />
				</div>
			</div><!-- /clearfix -->
			
			<div class="clearfix">
				<label for="xlInput">Anchor</label>
				<div class="input">
					<input class="xlarge" name="anchor" value="<?php echo $link["anchor"];?>" size="30" type="text" />
				</div>
			</div><!-- /clearfix -->
			
			<div class="clearfix">
				<label for="xlInput">Menu group</label>
				<div class="input">
					<input class="xlarge" name="menu_group" value="<?php echo $link["menu_group"];?>" size="30" type="text" />
				</div>
			</div><!-- /clearfix -->
			
			<div class="clearfix">
				<label for="xlInput">Menu priority</label>
				<div class="input">
					<input class="xlarge" name="menu_priority" value="<?php echo $link["menu_priority"];?>" size="30" type="text" />
				</div>
			</div><!-- /clearfix -->
				<br />
				<input class="btn success" type="submit" name="save" value="Save"/>
			</form>
		</div>
	</div>
	<?php get_footer(); ?>