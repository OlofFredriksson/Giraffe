<?php
get_header();
$url = get_siteInfo("url");
?>
<div class="container-fluid">
	<?php get_sidebar(); ?>
	<div class="content">	
	<div class="row">
		<div class="span16">
			<h2>Posts</h2>
			<p>Etiam porta sem malesuada magna mollis euismod. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
			<p><a class="btn primary" href="<?php echo $url;?>/dashboard/post/create">Create new post &raquo;</a></p>
			<table class="bordered-table zebra-striped">
				<thead>
					<tr>
						<th>Id</th>
						<th>Title</th>
						<th>Author</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>Some</td>
						<td>One</td>
					</tr>
					<tr>
						<td>2</td>
						<td>Joe</td>
						<td>Sixpack</td>
					</tr>
					<tr>
						<td>3</td>
						<td>Stu</td>
						<td>Dent</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<?php get_footer(); ?>