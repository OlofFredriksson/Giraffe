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
			<h2>Posts</h2>
			<p>Create new articles, or edit existing posts.</p>
			<p><a class="btn primary" href="<?php echo $url;?>/post/create">Create new post &raquo;</a></p>
			<table class="bordered-table zebra-striped">
				<thead>
					<tr>
						<th>Id</th>
						<th>Title</th>
						<th>Author</th>
						<th>Date</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					while ($row = $post_list->fetch_assoc()) {
						?>
						<tr>
							<td><?php echo $row["id"]; ?></td>
							<td><?php echo $row["title"]; ?></td>
							<td><?php echo $giraffe->auth->getUsername($row["idUser"]); ?></td>
							<td><?php echo $row["date"]; ?></td>
							<td><a href="/<?php the_siteinfo("base"); ?>post/edit/<?php echo $row["id"]; ?>" title="Edit post">Edit</a></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<?php get_footer(); ?>