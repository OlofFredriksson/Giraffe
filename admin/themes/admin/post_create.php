<?php
get_header();
$url = get_siteInfo("url");
?>
<div class="container-fluid">
	<?php get_sidebar(); ?>
	<div class="content">	
	<div class="row">
		<div class="span16">
			<h2>Create post</h2>
			<br style="clear:both;" />
			<form method="post" action="/admin/post/edit" class="form-stacked">
			<input name="id" type="hidden" value="<?php echo $post["id"];?>"/>
			<div class="clearfix">
			<label for="xlInput3">Title</label>
			<div class="input">
				<input class="xlarge" name="title" size="30" value="<?php echo $post["title"];?>" type="text" />
			</div>
			</div><!-- /clearfix -->
			<div class="clearfix">
				<label for="xlInput">Slug</label>
				<div class="input">
					<input class="xlarge" name="slug" value="<?php echo $post["slug"];?>" size="30" type="text" />
				</div>
			</div><!-- /clearfix -->
				<a href="javascript:;" onclick="tinyMCE.get('elm1').show();return false;">Visual</a>
				<a href="javascript:;" onclick="tinyMCE.get('elm1').hide();return false;">Code</a>
				<div>
					<textarea id="elm1" name="content" rows="15" cols="80" style="width: 100%">
						<?php echo $post["content"];?>
					</textarea>
				</div>
				<br />
				<input class="btn success" type="submit" name="save" value="Save"/>
			</form>
		</div>
	</div>
	<?php get_footer(); ?>